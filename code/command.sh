#!/bin/bash

# Laravel Student API Testing Script
# Updated for Laravel Sanctum authentication and RESTful API endpoints

API_BASE="http://localhost:8000/api/v1"
LOGIN_URL="$API_BASE/login"
TOKEN_FILE="token.txt"

echo "🚀 Testing Laravel Student API..."

# Clean up previous token file
rm -f $TOKEN_FILE

# 1) Login and get Sanctum token
echo "1️⃣ Logging in..."
RESPONSE=$(curl -s -X POST $LOGIN_URL \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Admin","password":"password"}')

echo "Login Response: $RESPONSE"

# Extract token from response
TOKEN=$(echo $RESPONSE | grep -o '"token":"[^"]*"' | cut -d'"' -f4)

if [ -z "$TOKEN" ]; then
    echo "❌ Login failed! Check credentials."
    exit 1
fi

echo "✅ Login successful! Token: ${TOKEN:0:20}..."
echo $TOKEN > $TOKEN_FILE

# Authorization header for subsequent requests
AUTH_HEADER="Authorization: Bearer $TOKEN"

echo ""
echo "🔍 Testing Student API endpoints..."

# 2) Get all students
echo "2️⃣ Getting all students..."
curl -s -X GET "$API_BASE/students" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 3) Get student by ID
echo "3️⃣ Getting student by ID (1)..."
curl -s -X GET "$API_BASE/students/1" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 4) Get students by Name
echo "4️⃣ Getting students by name (John)..."
curl -s -X GET "$API_BASE/students/by-name/John" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 5) Get students by Course
echo "5️⃣ Getting students by course (CSI123)..."
curl -s -X GET "$API_BASE/students/by-course/CSI123" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 6) Get students by Major
echo "6️⃣ Getting students by major (Computer)..."
curl -s -X GET "$API_BASE/students/by-major/Computer" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 7) Get students by Year
echo "7️⃣ Getting students by year (1)..."
curl -s -X GET "$API_BASE/students/by-year/1" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 8) Create new student
echo "8️⃣ Creating new student..."
curl -s -X POST "$API_BASE/students" \
  -H "$AUTH_HEADER" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Bob Johnson","course":"PSY204","major":"Psychology","year":3}' | jq '.'

echo ""

# 9) Update student (assuming ID 1 exists)
echo "9️⃣ Updating student (ID 1)..."
curl -s -X PUT "$API_BASE/students/1" \
  -H "$AUTH_HEADER" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{"name":"Alice Doe Updated","year":4}' | jq '.'

echo ""

# 10) Delete specific student (assuming ID 2 exists)
echo "🔟 Deleting student (ID 2)..."
curl -s -X DELETE "$API_BASE/students/2" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 11) Delete all students (Admin only)
echo "1️⃣1️⃣ Deleting all students (Admin only)..."
curl -s -X DELETE "$API_BASE/students/delete-all" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 12) Get user profile
echo "1️⃣2️⃣ Getting user profile..."
curl -s -X GET "$API_BASE/user" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""

# 13) Logout
echo "1️⃣3️⃣ Logging out..."
curl -s -X POST "$API_BASE/logout" \
  -H "$AUTH_HEADER" \
  -H "Accept: application/json" | jq '.'

echo ""
echo "✅ API testing complete!"

# Clean up
rm -f $TOKEN_FILE
