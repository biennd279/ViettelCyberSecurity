def parseTCPMsg(response: str):
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
