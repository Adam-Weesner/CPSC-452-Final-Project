import socket
import os
import sys


# Set up the connection socket
connSock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
connSock.connect(("localhost", 1234))

# Run commands indefinitely
while True:

    # Get the input choice from the user
    message = input("Message: ")

    bMessage = message.encode("utf-8")
    connSock.send(bMessage)
