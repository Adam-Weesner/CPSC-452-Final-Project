import socket

def Validate(username, password):
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    s.connect(('localhost', 4022))
    s.sendall("validate " + " " + username + " " + password)
    data = s.recv(1024)
    s.close()
    return data
