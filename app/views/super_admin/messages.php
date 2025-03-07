<body class="">
    <?php include('header.php'); ?>
    <div class="page-content admin-cover">
        <?php include('sidebar.php'); ?>
        <div class="content-wrapper">
            <div class="content-inner">
                <div class="content">
                    <div class="row mb-3">
                        <!-- Contacts List -->
                        <div class="col-12 col-lg-6 mb-3 mb-lg-0">
                            <div class="card h-100">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h6 class="card-title">Contacts</h6>
                                </div>
                                <div class="card-body overflow-auto" id="contacts-list">
                                    <?php foreach ($contacts as $contact) : ?>
                                        <div class="d-flex align-items-center mb-3 hoverEffect contact-item"
                                            data-userid="<?= $contact['user_id'] ?>"
                                            data-role="<?= $contact['user_role'] ?>"
                                            data-name="<?= $contact['user_name'] ?>">
                                            <div class="avatar avatar-sm me-3 position-relative">
                                                <img src="/public/assets/images/user.png" class="avatar-img rounded-circle" alt="<?= $contact['user_name'] ?>" style="width: 50px">
                                                <span class="position-absolute bottom-0 end-0 badge bg-success rounded-circle online-indicator" style="display: none;"></span>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0"><?= $contact['user_name'] ?></h6>
                                                <span class="text-capitalize"><?= $contact['user_role'] ?></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Container -->
                        <div class="col-12 col-lg-6">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="mb-0" id="chat-partner-name">Select a contact to start chatting</h5>
                                </div>

                                <div class="card-body">
                                    <div class="media-chat-scrollable mb-3" style="height: 400px; overflow-y: auto;" id="chat-messages">
                                        <div class="media-chat vstack gap-3" id="messages-container">
                                            <!-- Messages will be loaded here -->
                                        </div>
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" id="message-input"
                                            placeholder="Type message here..."
                                            aria-label="Message input">
                                        <button class="btn btn-primary" type="button" id="send-button">
                                            Send <i class="ph-paper-plane-tilt ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let currentReceiver = null;
            const currentUserId = <?= $_SESSION['user_id'] ?? 0 ?>;

            // Initialize Pusher
            const pusher = new Pusher('79462a5abaa97adfea67', {
                cluster: 'ap1',
                forceTLS: true
            });

            // Contact click handler
            $('.contact-item').click(function() {
                currentReceiver = {
                    id: $(this).data('userid'),
                    name: $(this).data('name'),
                    role: $(this).data('role')
                };

                $('#chat-partner-name').text(currentReceiver.name);
                loadChatHistory(currentReceiver.id);
                setupPusherChannel(currentReceiver.id);
            });

            // Send message handler
            $('#send-button').click(sendMessage);
            $('#message-input').keypress(function(e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            function loadChatHistory(receiverId) {
                $.ajax({
                    url: '/message/getMessages/' + receiverId,
                    method: 'GET',
                    success: function(response) {
                        $('#messages-container').empty();
                        response.messages.forEach(message => {
                            appendMessage(message);
                        });
                        scrollToBottom();
                    }
                });
            }

            function appendMessage(message) {
                const isSender = message.sender_id == currentUserId;
                const messageClass = isSender ? 'media-chat-item-reverse' : 'media-chat-item';
                const timestamp = new Date(message.timestamp).toLocaleString();

                const messageHtml = `
                    <div class="media-chat-item ${messageClass}">
                        <div class="media-chat-message">
                            <div class="fs-sm lh-sm">
                                <span class="fw-semibold">${isSender ? 'You' : message.sender_name}</span>
                                <span class="opacity-50 ms-2">${timestamp}</span>
                            </div>
                            ${message.message}
                        </div>
                    </div>
                `;
                $('#messages-container').append(messageHtml);
                scrollToBottom();
            }

            function sendMessage() {
                const messageText = $('#message-input').val().trim();
                if (!messageText || !currentReceiver) return;

                $.ajax({
                    url: '/message/sendMessage',
                    method: 'POST',
                    data: {
                        receiver_id: currentReceiver.id,
                        message: messageText
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#message-input').val('');
                            appendMessage({
                                sender_id: currentUserId,
                                message: messageText,
                                timestamp: new Date().toISOString(),
                                sender_name: 'You'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error sending message:', xhr.responseText);
                    }
                });
            }

            function setupPusherChannel(receiverId) {
                const channel = pusher.subscribe('chat-channel-' + currentUserId);

                channel.bind('new-message', function(data) {
                    if (data.sender == receiverId) {
                        appendMessage({
                            sender_id: data.sender,
                            message: data.message,
                            timestamp: data.timestamp,
                            sender_name: currentReceiver.name
                        });
                    }
                });
            }

            function scrollToBottom() {
                const container = $('#chat-messages');
                container.scrollTop(container[0].scrollHeight);
            }

            // Initial setup for online status
            const presenceChannel = pusher.subscribe('presence-chat');
            presenceChannel.bind('pusher:subscription_succeeded', () => {
                $('.contact-item').each(function() {
                    const userId = $(this).data('userid');
                    const isOnline = presenceChannel.members.get(userId);
                    $(this).find('.online-indicator').toggle(!!isOnline);
                });
            });

            presenceChannel.bind('pusher:member_added', (member) => {
                $(`.contact-item[data-userid="${member.id}"] .online-indicator`).show();
            });

            presenceChannel.bind('pusher:member_removed', (member) => {
                $(`.contact-item[data-userid="${member.id}"] .online-indicator`).hide();
            });
        });
    </script>
</body>

</html>