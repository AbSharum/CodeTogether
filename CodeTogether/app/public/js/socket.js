let socket;

function connectSocket() {
  socket = new WebSocket("ws://" + window.location.host + "/live");


  socket.onopen = () => {
    console.log("Connected to live updates");
  };

  socket.onmessage = (event) => {
    try {
      const { event: type, data } = JSON.parse(event.data);
      handleSocketEvent(type, data);
    } catch (e) {
      console.error("Invalid socket message:", event.data);
    }
  };

  socket.onclose = () => {
    console.warn("Socket disconnected, retrying in 3s...");
    setTimeout(connectSocket, 3000);
  };

  socket.onerror = (err) => console.error("Socket error:", err);
}

function handleSocketEvent(type, data) {
  switch (type) {
    case "newPost": return onNewPost?.(data);
    case "deletePost": return onPostDeleted?.(data);
    case "newComment": return onNewComment?.(data);
    case "newUser": return onNewUser?.(data);
    case "friendRequest": return onFriendRequest?.(data);
    case "friendRequestResponse": return onFriendAccepted?.(data);
    case "statusChange": return onStatusChange?.(data);
    default:
      console.log("Unhandled event:", type, data);
  }
}

connectSocket();
