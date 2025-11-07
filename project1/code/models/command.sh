# This is a placeholder for your curl commands.
# This is a placeholder for your curl commands.
#!/bin/bash
API="http://localhost:8000/EPindex.php"
LOGIN="http://localhost:8000/login.php"
COOKIE="cookies.txt"

# 1) Login
curl -c $COOKIE -X POST $LOGIN -d "username=admin&password=Admin123@"

# 2) Get all students
curl -b $COOKIE "$API?action=all"

# 3) Get by ID
curl -b $COOKIE "$API?action=get&id=1"


# 4) Get by Name
curl -b $COOKIE "$API?action=name&name=John"


# 5) Get by Course
curl -b $COOKIE "$API?action=course&course=CSI123"

# 6) Get by Major
curl -b $COOKIE "$API?action=major&major=Computer"

# 7) Get by Year
curl -b $COOKIE "$API?action=year&year=1"

# 8) Create Student
curl -b $COOKIE -X POST "$API?action=create" \
  -H "Content-Type: application/json" \
  -d '{"name":"Bob","course":"PSY204","major":"Physics","year":3}'

# 9) Update Student
curl -b $COOKIE -X POST "$API?action=update&id=1" \
  -H "Content-Type: application/json" \
  -d '{"name":"Alice Doe","year":3}'

# 8) Delete Student
curl -b $COOKIE -X POST "$API?action=delete&id=2"

# 9) Delete All
curl -b $COOKIE -X POST "$API?action=delete_all"
