# LTW 2020/2021

# Elements:
 - Luís Miguel Pinto (201806206) 
 - Nuno Oliveira (201806525)
 - Pedro Coelho (201806802)

# Credentials (username/password (role))
 - default_user/12345678 (client)
 - soraiafq/passsuspeita (client)
 - raiofalcao/naoseimesmo (client)
 - pereirapulmoes/grandespulmoes (client)
 - joaopao/comeapapa (client)

# Libraries:
 - No external libraries used
 - php gd2 and pdo_sqlite extensions must be activated

# Link to website on gnomo server: https://web.fe.up.pt/~up201806206/ltw/project/

# Features:
 - Security
     - XSS: yes
     - CSRF: yes
     - SQL using prepare/execute: yes
     - Passwords: password_hash and salt
     - Data Validation: regex / php / javascript / ajax
 - Technologies
     - Separated logic/database/presentation: yes
     - Semantic HTML tags: yes
     - Responsive CSS: no (however number of images per row adapts to window width)
     - Javascript: yes
     - Ajax: yes
     - REST API: no
  - Usability:
     - Error/success messages: yes
     - Forms don't lose data on error: yes (we remove data where we think it is convenient, e.g. non-existing username on login we remove username and password)
     - All references to a user's username or an animal is a link to his/its profile
     - All minimum expected requirements were implemented with the addition of a navbar on the header, both adoptions and proposals have states and the posting of additional photos

  
