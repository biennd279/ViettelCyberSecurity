import socket


def createSocket(hostname: str, port: int):
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.connect((hostname, port))
    return sock


def sendTcpMsg(sock: socket, msg: bytes):
    sock.sendall(msg)
    response = b""
    while True:
        chunk = sock.recv(4096)
        if not chunk:
            break
        response += chunk
    return response


def parseTcpMsg(response: str):
    header = response[:response.find("\r\n\r\n")]
    body = response[response.find("\r\n\r\n") + 4:response.rfind("\r\n\r\n") - 1]

    if header.find("chunked") != -1:
        _body = []
        body = body.split("\r\n")
        for i in range(0, len(body)):
            if i % 2 == 1:
                _body.append(body[i])
            # TODO
        body = ''.join(_body)
    return header, body
