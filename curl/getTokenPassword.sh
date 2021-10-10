curl -s -X POST 'http://localhost:8180/auth/realms/master/protocol/openid-connect/token' \
--data-urlencode 'grant_type=password' \
--data-urlencode 'cliend_id=admin-cli' \
--data-urlencode 'username=admin' \
--data-urlencode 'password=Qazx1234'
