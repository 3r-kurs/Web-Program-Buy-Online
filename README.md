# BuyOnline

## File descriptions

### Overview

-   data directory:
    All the files in `data/` directory contain information associated with the project.

-   `*.php` files:
    Basically means the backend side of the project. Their purpose is to validate the request payload, access data, and provide the response along with the status code to determine the completion of the request.

-   `*.html` files:
    On the other hand, these files represent the frontside of the project. Most of them contain html, css, and javascript to display the UI and send request using JQuery and Bootstrap version 3.

-   `utils.*` files:
    Contains the frequently used functions for the purpose of optimization.

-   `alert.html`:
    The HTML of message notifier.

-   `styles.css`:
    Makes the background-color of the body to little gray shaded color `#dcdcdc`

### Detailed Informations

-   `index.html`:
    The initial URI to redirect to `buyonline.html`.

-   `buyonline.html`:
    The sitemap page for BuyOnline which contains 2 option to continue as `Customer` or `Manager`.

-   `login.html`:
    The login page for `Customer` which contains `Email` and `Password` fields with `Login` button and `Sign Up` button to register new customer.

-   `login.php`:
    Checks if there is a user with given `Email` and `Password`. If exists, return the user information and creates session to authenticate.

-   `register.html`:
    The register page for `Customer`. In this page, `email, lastname, firstname, password, re-type password, and phone number` fields are included. All fields except `phone number` are tagged required on html input tag. Then the js script checks whether the `password` matches `re-type password`, and hashes the password with md5 to protect the user credentials. Also if the `phone number` is given, it is checked against `\(?0\d\)?\s?\d{8}` regex.

-   `register.php`:
    All the fields from `register.html` is sent to this file to validated and create a user with unique email and id.

-   `buying.*`:
    The only page for `Customer`. It has all the products in a table with their name, description, price, and available quantity provided. And customer can add each product to their cart, remove from it, purchase all the products in cart, and cancel purchase to remove all from cart.

-   `listing.*`:
    The one of two `Manager` page. It basically adds product to the list. Of course it has its fields required.

-   `processing.*`:
    Shows all the sold products with their name, price, available quantity, on hold quantity, and sold quantity. In the bottom of the page `Process` button, which removes products with 0 available quantity, and make all sold quantity to 0 on clicked, is placed.
