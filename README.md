# bitlab - Student Coding Lab
Coding examination website with automatic grading of student-submitted code

### Dependencies
- PHP 7.x/8.x Support (with mysqli module enabled)
  - Mostly built and tested on PHP 7.4, but 8.x should work as well.
- Database (for user data, submissions, etc)
- SSL/TLS cert not required, but highly recommended.

---
### Expected Database Structure

#### bitlab.users
| GUID (P) | Username | Password | First name | Last name | Admin Role | Date Updated | Last Seen |
|:-----:|:-----:|:-----:|:-----:|:-----:|:-----:|:-----:|:-----:|
|smallint(5) ~|varchar(255)|varchar(255)|varchar(255)|varchar(255)|tinyint(1) ^|timestamp|timestamp|
Admin role shall be 0:User, 1:User Admin (add/drop users, add/drop/assign courses)

#### courses.assignments
| Assignment ID (P)| Course GUID | Assignment name | Date opened | Date closed |
|:-----:|:-----:|:-----:|:-----:|:-----:|
|mediumint(7) ~|smallint(5) ~|varchar(255)|timestamp|timestamp|

#### courses.available-courses
| Course GUID (P) | Course Code | Course Name |
|:-----:|:-----:|:-----:|
|smallint(5) ~|varchar(255)|varchar(255)|

#### courses.course-membership
| Course GUID | Member GUID | Role |
|:-----:|:-----:|:-----:|
|smallint(5) ~|smallint(5) ~|tinyint(1) ^|
Member role shall be 0:Student, 1:TA, or 2:Instructor

Symbols included in the data types...
**(P)** Primary key,
**^** Unsigned,
**~** Unsigned Zerofill

Some changes are allowed without updating the code, such as changing a smallint to an int. These sizes were chosen with the expectation that most users would not need anything larger.

---

#### The following projects were used under the Apache 2.0 license.
- Material Design Icons - [google/material-design-icons](https://github.com/google/material-design-icons)