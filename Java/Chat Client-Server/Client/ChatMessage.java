import java.io.*;

public class ChatMessage implements Serializable {

    private String roomName;
    static final int WHOISIN = 0, MESSAGE = 1, LOGOUT = 2, LOGIN = 3;
    private int type;
    private String message;

    ChatMessage(String roomName, int type, String message) {
        this.roomName = roomName;
        this.type = type;
        this.message = message;
    }

    int getType() {
        return type;
    }
    String getMessage() {
        return message;
    }
    String getRoomName() { return roomName; }
}

