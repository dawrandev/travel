# API Testing Guide

## Base URL
```
http://travel.test/api
```

## Swagger Documentation
```
http://travel.test/api/documentation
```

## Tours API

### 1. Get All Tours
```bash
GET /api/tours
```

**Headers:**
```
Accept-Language: uz  # uz, ru, kk, en
```

**Query Parameters:**
- `category_id` (optional) - Filter by category

**Example:**
```bash
curl -H "Accept-Language: ru" http://travel.test/api/tours
curl http://travel.test/api/tours?category_id=1
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Orol dengizi safari",
      "description": "Ajoyib sayohat...",
      "routes": "Toshkent - Nukus - Moynaq",
      "important_info": "Pasport talab qilinadi",
      "price": 1500000,
      "duration_days": 3,
      "duration_nights": 2,
      "min_age": 18,
      "max_people": 15,
      "rating": 4.5,
      "reviews_count": 10,
      "category": {
        "id": 1,
        "name": "Tabiiy safari"
      },
      "main_image": "http://travel.test/storage/tours/main.jpg",
      "images": [...],
      "itineraries": [
        {
          "day_number": 1,
          "event_time": "09:00",
          "activity_title": "Toshkentdan jo'nash",
          "activity_description": "..."
        }
      ],
      "features": [
        {
          "id": 1,
          "name": "Transport",
          "description": "...",
          "icon": "fas fa-bus"
        }
      ]
    }
  ]
}
```

### 2. Get Single Tour
```bash
GET /api/tours/{id}
```

**Headers:**
```
Accept-Language: uz
```

**Example:**
```bash
curl -H "Accept-Language: en" http://travel.test/api/tours/1
```

## Reviews API

### 1. Get All Reviews
```bash
GET /api/reviews
```

**Headers:**
```
Accept-Language: uz
```

**Query Parameters:**
- `tour_id` (optional) - Filter by tour

**Example:**
```bash
curl -H "Accept-Language: ru" http://travel.test/api/reviews
curl http://travel.test/api/reviews?tour_id=1
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "user_name": "Alisher Navoiy",
      "rating": 5,
      "review_text": "Ajoyib tur edi!",
      "video_url": "https://youtube.com/watch?v=xxx",
      "tour": {
        "id": 1,
        "title": "Orol dengizi safari"
      }
    }
  ]
}
```

### 2. Get Single Review
```bash
GET /api/reviews/{id}
```

**Headers:**
```
Accept-Language: uz
```

**Example:**
```bash
curl -H "Accept-Language: kk" http://travel.test/api/reviews/1
```

## Bookings API

### Create Booking
```bash
POST /api/bookings
```

**Request Body (JSON):**
```json
{
  "tour_id": 1,
  "full_name": "Alisher Navoiy",
  "phone_primary": "+998901234567",
  "phone_secondary": "+998909876543",
  "booking_date": "2026-02-15",
  "people_count": 2,
  "comment": "Men vegetarian ovqat xohlayman"
}
```

**Required fields:**
- `tour_id` (integer) - Tour ID
- `full_name` (string, max 255) - Full name
- `phone_primary` (string, max 20) - Primary phone number
- `booking_date` (date, YYYY-MM-DD, today or future) - Booking date
- `people_count` (integer, min 1) - Number of people

**Optional fields:**
- `phone_secondary` (string, max 20) - Secondary phone number
- `comment` (string, max 1000) - Comment

**Price Calculation (Backend):**
Total price is calculated automatically based on tour price and number of people:
- 1 person: 100% of tour price per person
- 2 people: 80% of tour price per person
- 3 people: 60% of tour price per person
- 4 people: 56% of tour price per person
- 5 people: 52% of tour price per person
- 6 people: 52% of tour price per person
- 7+ people: 48% of tour price per person

Example: If tour price = 1,000,000 UZS and people_count = 2:
- Price per person: 1,000,000 * 0.8 = 800,000 UZS
- Total price: 800,000 * 2 = 1,600,000 UZS

**Example:**
```bash
curl -X POST http://travel.test/api/bookings \
  -H "Content-Type: application/json" \
  -d '{
    "tour_id": 1,
    "full_name": "Alisher Navoiy",
    "phone_primary": "+998901234567",
    "phone_secondary": "+998909876543",
    "booking_date": "2026-02-15",
    "people_count": 2,
    "comment": "Men vegetarian ovqat xohlayman"
  }'
```

**Success Response (201):**
```json
{
  "success": true,
  "message": "Booking created successfully",
  "data": {
    "id": 1,
    "tour_id": 1,
    "full_name": "Alisher Navoiy",
    "phone_primary": "+998901234567",
    "phone_secondary": "+998909876543",
    "booking_date": "2026-02-15",
    "people_count": 2,
    "total_price": 1600000.00,
    "price_per_person": 800000.00,
    "status": "pending",
    "comment": "Men vegetarian ovqat xohlayman"
  }
}
```

**Note:** `total_price` and `price_per_person` are automatically calculated by the backend.

**Error Response (422):**
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "phone_primary": [
      "Primary phone number is required."
    ],
    "booking_date": [
      "Booking date must be today or in the future"
    ]
  }
}
```

## Language Support

**Supported languages:**
- `uz` - O'zbek (default)
- `ru` - Русский
- `kk` - Қазақша
- `en` - English

**Usage:**
```
Accept-Language: ru
```

## Response Format

All endpoints return:
```json
{
  "success": true,
  "data": {...}
}
```

Error response (404):
```json
{
  "message": "No query results for model..."
}
```

## Notes

1. ✅ **Clean response** - No `translations` object, direct fields
2. ✅ **Language support** - Use `Accept-Language` header
3. ✅ **Nested relations** - Category, features, itineraries included
4. ✅ **Full URLs** - Images return full URLs with `asset()`
5. ✅ **Swagger docs** - Available at `/api/documentation`
6. ✅ **Frontend friendly** - Easy to consume, no complex nesting
