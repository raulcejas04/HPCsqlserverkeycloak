curl -s -X POST 'http://localhost:8180/auth/realms/master/protocol/openid-connect/token' \
-d 'grant_type=password' \
-d 'client_id=admin-cli' \
-d 'username=admin' \
-d 'password=Qazx1234'
