# RSA

### `openssl` 生成公钥私钥
- `openssl genrsa -out rsa_private_key.pem`
- `openssl rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem`

### 公钥加密，私钥解密（只有自己才可以解密）

### 私钥签名，公钥验证（只有自己才可以发布签名）
