API Documentation
=================

# Login

Permet de se connecter à l'application. Cet endpoint définis les variables de sessions si l'email et le password correspondent bien à un utilisateur enregistré.

```
POST $HOST/backEnd/action/loginAction.php

{
    "email": "example@company.com",
    "mp": "passwordExample",
}
```

Erreur possibles :
  * There is no email or password in the request
  * There is no user with this email in db
  * User is not authorize to login
  * Password incorrect

# Register

```
POST $HOST/backEnd/action/registerAction.php

{
    "email": "example@company.com",
    "mp": "passwordExample",
    "mp_confirm": "passwordExample",
}
```

Erreur possibles :
  * There is no email or password or confirmPasswod in the request
  * The email is not valid
  * This email already exists in the Db
  * The password and confirmation password are not the same
