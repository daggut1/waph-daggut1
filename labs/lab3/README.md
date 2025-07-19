
# Lab 3 – Secure Web Login Development with SQL Injection and XSS

**Course**: Web Application Programming and Hacking  
**Instructor**: Dr. Phu H. Phung  
**Student**: Thanooj Daggu  
**GitHub Repo**: https://github.com/waph-daggut1/tree/main/labs/lab3  
**Lab Folder**: labs/lab3  


---

## Headshot:

![Headshot](headshot.jpeg)

---

## Overview

This lab involved building a simple PHP login system backed by a MySQL database. I tested it for SQL Injection and XSS vulnerabilities, then applied security fixes using prepared statements and output sanitization. The lab emphasized the importance of writing secure backend code for web applications.

---

## Section A – Database Setup and Management

I created the MySQL database `waph` and user `muddamn1`. I built a `users` table and inserted one sample user `daggut1` with an MD5-hashed password. The user was created with full access permissions to the `waph` database.

![](1.png)
*Figure 2:user table after insert*

![](2.png)  
*Figure 3:MD5 hash*

---

## Section B – A Simple (Insecure) Login System with PHP/MySQL 

I created a basic login form using HTML and PHP. The form posts credentials to `index.php`, which connects to the MySQL database and verifies them. At first, the login logic was written using a plain SQL query with raw user inputs, making it vulnerable to attacks.

![](3.png)
*Figure 4: Login Page*

![](4.png)  
*Figure 5: Successful login*

---

## Section C – Performing SQL Injection and XSS Attacks

### C.1 SQL Injection Attack

I used `' OR 1=1 --` in the username field to bypass the login. Because the SQL query included the user input directly, the condition always evaluated true, allowing unauthorized access.

![](5.jpeg)
*Figure 6: SQL Injection bypass*

---

### C.2 Cross-site Scripting (XSS) Attack

To test XSS, I submitted `<script>alert(document.cookie)</script>` in the username field. The code executed in the browser and showed the session ID in a popup, confirming that the input was not sanitized.

![](6.png)
*Figure 7: XSS popup*

---

## Section D – Prepared Statement Implementation and Security Analysis

### D.1 Prepared Statement for SQL Injection Prevention 

I updated `index.php` to use a prepared statement. By separating the query logic and input data, I eliminated the SQL injection risk. The injected condition no longer caused a login bypass.

```php
function checklogin_secure($username, $password) {
    $mysqli = new mysqli('localhost', 'daggut1', 'Thanooj@2621', 'waph');
    if ($mysqli->connect_errno) {
        printf("Database connection failed: %s\n", $mysqli->connect_error);
        exit();
    }
    $sql = "SELECT * FROM users WHERE username = ? AND password = md5(?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result && $result->num_rows == 1);
}
```
![](7.png)
*Figure 9: SQL injection*  

![](8.png)
*Figure 10: login with invalid input rejected*

---

### D.2 Security Analysis

I used `htmlentities()` to sanitize user output and prevent XSS attacks. This change made sure scripts were shown as plain text rather than being executed.

```php
<h2> Welcome <?php echo htmlentities($_POST['username']); ?> !</h2>
```
![](3.png)
*Figure 11: Security Analysis* 
![](4.png) 
*Figure 12: Successful login*

---

### D.3 Programming Vulnerabilities Discussion 

The code still has a few issues:
- No checks for empty inputs or invalid data formats
- No session variables used for tracking logged-in users
- Repeated failed logins are not rate-limited
- Password strength is not enforced

---

## My Commits

![](commits.png) 
*Figure 13: commits for Lab 3*

---


