import socket
import os
import sys


# Set up the connection socket
welcomeSock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
welcomeSock.bind(('', 1234))

# Listen and accept the connection
welcomeSock.listen(5)
print("Waiting for connections...")
clientSock, addr = welcomeSock.accept()
print("Accepted connection from client: ", addr)
print("\n")


# Keep accepting commands
while True:

    # Receive the choice
    message = clientSock.recv(1024)

    print(message.decode())
