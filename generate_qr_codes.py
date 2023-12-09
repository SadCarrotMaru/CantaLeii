import segno
codes = open("qr_codes.txt","r")

for line in codes:
    split_result = line.split()
    QR_CODE = split_result[-1]

    URL = "https://cantaleii.alwaysdata.net/index.php?qrcode=" + '"' + QR_CODE.strip() + '"'
    qrcode = segno.make_qr(URL)
    
    name = ' '.join(split_result[:-1])
    qrcode.save("qrcodes/" + name + ".png", scale = 10)