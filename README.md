## Setup Instructions

1. Install XAMPP
2. Clone the repository:
   git clone https://github.com/sylvia-619/myproject.git
3. Move project to htdocs create folder called afya
4. Start Apache and MySQL
5. Open browser and go to:
   http://localhost/afya/index.php
   ## Handshake Flow

1. Client sends request with API key
2. Server validates API key
3. Server generates a token
4. Token is used for subsequent requests
    ## Expiry Handling

- Tokens expire after 15 minutes
- Expired tokens are rejected
- User must request a new token
