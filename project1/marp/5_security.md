---
marp: true
html: true
size: 4:3
paginate: true
style: |
  strong {
    text-shadow: 1px 1px 4px #000000;
  }
  @media print {
    strong {
      text-shadow: none !important;
      -webkit-text-stroke: 0.6px rgba(0,0,0,0.35);
      text-stroke: 0.6px rgba(0,0,0,0.35); /* ignored by many, harmless */
    }
  }
  img[alt~="center"] {
    display: block;
    margin: 0 auto;
  }
    img[alt~="outline"] {
    border: 2px solid #388bee;
  }
  .columns {
    display: flex;
    gap: 2rem;
  }
  .column {
    flex: 1;
  }
---

<!-- _class: lead -->
<!-- _class: frontpage -->
<!-- _paginate: skip -->

# Security Features of REST APIs

---
# Description for Security features for the API

The main security features being used for the Student API is hash passwords and session authorization.
---
Hash password occur whenever a new user registers a new account where it will take password value they inputted into box on regsiter.php. Then the server send their inputs though the auth.php file where it first checks the password strength by checking if the password meets requirements the runs the password string through the password_hash function where it takes the the password string and run it through the PASSWORD_DEFAULT algolthem in which hashs or encrypts the password before making it the value for the new hash_password string.
---
The session authorization centers on the sessionsauth.php checking if the user is login from the dbusers.json data file, should user not be logged in via sessionauth in the index.php, it would only provide access to the login button tothe login.php page. Here, they enter their username or password if they have made an account or can register a account.once they enter their username and password, their inputs are sent through auth.php to check if user is in the dbusers database using the jsondatabase.php file, if it finds username and the user entered the correct password then the API makes a session cookie to log and save interactions from the user and redirects them to the index.php page, if the wrong password was given it redirects the user back to the login page, gives them an error and points them for failed attempt, if 5 failed attempts were done then it timeout the user for 15 minutes. When the user logs off the the session cookie is destoryed, and user is sent to the logout.php page.
---
# The endpoints for the security system 
The endpoints used for the hash password  

From auth.php:

 validate_password_strengh, change_password, find_by_id, login, and password_hash
---
For the endpoints of session authorization; in sessionauth.php:
 
 __construct, login_user, is_logged_in, get_current user, logout, require_auth, is_guest, get_session_info, and require_guest.
---