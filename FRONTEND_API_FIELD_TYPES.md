# Frontend API Field Types Reference

Bu dokumentatsiya Next.js da TypeScript types yaratish uchun zarur bo'lgan barcha field type'larini o'z ichiga oladi.

---

## GET /tours - Barcha turlar

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| slug | string | Yes | No | | |
| title | string | Yes | No | | |
| phone | string | Yes | No | | |
| description | string | Yes | No | | |
| routes | string | Yes | No | | |
| important_info | string | Yes | No | | |
| price | number | Yes | No | | |
| duration_days | integer | Yes | No | | |
| duration_nights | integer | Yes | No | | |
| min_age | integer | Yes | No | | |
| max_people | integer | Yes | No | | |
| rating | number | Yes | No | | |
| reviews_count | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |
| category.id | integer | Yes | No | | |
| category.name | string | Yes | No | | |
| main_image | string | Yes | No | | |
| images[].id | integer | Yes | No | | |
| images[].url | string | Yes | No | | |
| images[].is_main | boolean | Yes | No | | |

### Query Parameters

| Parameter | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| category_id | integer | No | No | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /tours/{slug} - Tur batafsil ma'lumoti

### Path Parameters

| Parameter | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| slug | string | Yes | No | | |

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| slug | string | Yes | No | | |
| title | string | Yes | No | | |
| phone | string | Yes | No | | |
| slogan | string | Yes | No | | |
| description | string | Yes | No | | |
| routes | string | Yes | No | | |
| important_info | string | Yes | No | | |
| price | number | Yes | No | | |
| duration_days | integer | Yes | No | | |
| duration_nights | integer | Yes | No | | |
| min_age | integer | Yes | No | | |
| max_people | integer | Yes | No | | |
| rating | number | Yes | No | | |
| reviews_count | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |
| category.id | integer | Yes | No | | |
| category.name | string | Yes | No | | |
| main_image | string | Yes | No | | |
| images[].id | integer | Yes | No | | |
| images[].url | string | Yes | No | | |
| images[].is_main | boolean | Yes | No | | |
| gif_map | string | No | Yes | | |
| itineraries[].day_number | integer | Yes | No | | |
| itineraries[].event_time | string | Yes | No | HH:MM | |
| itineraries[].activity_title | string | Yes | No | | |
| itineraries[].activity_description | string | Yes | No | | |
| features[].id | integer | Yes | No | | |
| features[].name | string | Yes | No | | |
| features[].description | string | Yes | No | | |
| features[].icon | string | Yes | No | | |
| features[].is_included | boolean | Yes | No | | |
| accommodations[].day_number | integer | Yes | No | | |
| accommodations[].type | string | Yes | No | | accommodation, recommendation |
| accommodations[].name | string | Yes | No | | |
| accommodations[].description | string | Yes | No | | |
| accommodations[].price | number | No | Yes | | |
| accommodations[].image | string | No | Yes | | |
| faq[].title | string | Yes | No | | |
| faq[].questions[].question | string | Yes | No | | |
| faq[].questions[].answer | string | Yes | No | | |
| reviews[].id | integer | Yes | No | | |
| reviews[].user_name | string | Yes | No | | |
| reviews[].rating | integer | Yes | No | | |
| reviews[].comment | string | Yes | No | | |
| reviews[].city | string | Yes | No | | |
| reviews[].video_url | string | No | Yes | | |
| reviews[].created_at | string | Yes | No | date-time | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /tours/top-rated - Eng yuqori ratingli turlar

Qaysi field'lar qaytariladi: `/tours` endpoint'idagi kabi (включая is_active)

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /categories - Barcha kategoriyalar

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| name | string | Yes | No | | |
| sort_order | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /categories/banner - Kategoriyalar banneri

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| title | string | Yes | No | | |
| is_active | boolean | Yes | No | | |
| images[] | string | Yes | No | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /about - Biz haqimizda

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| title | string | Yes | No | | |
| description | string | Yes | No | | |
| is_active | boolean | Yes | No | | |
| images[].id | integer | Yes | No | | |
| images[].image_path | string | Yes | No | | |
| award.description | string | Yes | No | | |
| award.images[].id | integer | Yes | No | | |
| award.images[].image_path | string | Yes | No | | |

Izoh: `award` ob'ektining o'zi nullable bo'lishi mumkin (No | Yes)

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | kk, uz, ru, en | uz |

---

## GET /about/banner - About banneri

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| title | string | Yes | No | | |
| is_active | boolean | Yes | No | | |
| images[] | string | Yes | No | | |

---

## GET /contact - Bog'lanish ma'lumotlari

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| phone | string | Yes | No | | |
| email | string | Yes | No | | |
| longitude | string | Yes | No | | |
| latitude | string | Yes | No | | |
| telegram_url | string | Yes | No | | |
| telegram_username | string | Yes | No | | |
| instagram_url | string | Yes | No | | |
| instagram_username | string | Yes | No | | |
| facebook_url | string | Yes | No | | |
| facebook_name | string | Yes | No | | |
| youtube_url | string | Yes | No | | |
| whatsapp_phone | string | Yes | No | | |

---

## GET /contact/banner - Contact banneri

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| title | string | Yes | No | | |
| is_active | boolean | Yes | No | | |
| images[] | string | Yes | No | | |

---

## GET /reviews - Barcha sharhlar

**Izoh:** Faqat admin tomonidan yaratilgan sharhlarni qaytaradi (client_created = false)

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| user_name | string | Yes | No | | |
| city | string | Yes | No | | |
| comment | string | Yes | No | | |
| rating | integer | Yes | No | | |
| sort_order | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |
| video_url | string | No | Yes | | |
| tour.id | integer | Yes | No | | |
| tour.title | string | Yes | No | | |

### Query Parameters

| Parameter | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| tour_id | integer | No | No | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## POST /reviews - Yangi sharh qo'shish

### Request Body Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| tour_id | integer | Yes | No | | |
| name | string | Yes | No | | |
| email | string | Yes | No | email | |
| rating | integer | Yes | No | | |
| comment | string | Yes | No | | |

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| tour_id | integer | Yes | No | | |
| name | string | Yes | No | | |
| rating | integer | Yes | No | | |
| comment | string | Yes | No | | |
| is_checked | boolean | Yes | No | | |
| created_at | string | Yes | No | date-time | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /reviews/{id} - Bitta sharh

### Path Parameters

| Parameter | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| user_name | string | Yes | No | | |
| city | string | Yes | No | | |
| comment | string | Yes | No | | |
| rating | integer | Yes | No | | |
| sort_order | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |
| video_url | string | No | Yes | | |
| tour.id | integer | Yes | No | | |
| tour.title | string | Yes | No | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /reviews/banner - Reviews banneri

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| title | string | Yes | No | | |
| is_active | boolean | Yes | No | | |
| images[] | string | Yes | No | | |

---

## GET /hero-slides - Bosh sahifa slaydlari

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| image_path | string | Yes | No | | |
| sort_order | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |
| title | string | Yes | No | | |
| subtitle | string | Yes | No | | |
| description | string | No | Yes | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | kk, uz, ru, en | uz |

---

## GET /faq - Umumiy FAQ larni olish

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| sort_order | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |
| question | string | Yes | No | | |
| answer | string | Yes | No | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## GET /faq/categories - FAQ kategoriyalari

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| name | string | Yes | No | | |
| sort_order | integer | Yes | No | | |
| is_active | boolean | Yes | No | | |

### Headers

| Header | Type | Required | Nullable | Format | Enum | Default |
|---|---|---|---|---|---|---|
| Accept-Language | string | No | No | | uz, ru, kk, en | uz |

---

## POST /bookings - Yangi bron yaratish

### Request Body Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| tour_id | integer | Yes | No | | |
| full_name | string | Yes | No | | |
| max_people | integer | Yes | No | | |
| starting_date | string | Yes | No | YYYY-MM-DD | |
| ending_date | string | Yes | No | YYYY-MM-DD | |
| primary_phone | string | Yes | No | | |
| secondary_phone | string | No | No | | |
| email | string | Yes | No | email | |
| message | string | No | No | | |

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| tour_id | integer | Yes | No | | |
| full_name | string | Yes | No | | |
| max_people | integer | Yes | No | | |
| starting_date | string | Yes | No | | |
| ending_date | string | Yes | No | | |
| primary_phone | string | Yes | No | | |
| secondary_phone | string | Yes | No | | |
| email | string | Yes | No | | |
| message | string | Yes | No | | |
| status | string | Yes | No | | pending, confirmed, cancelled |

---

## POST /questions - Savol yuborish

### Request Body Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| tour_id | integer | Yes | No | | |
| full_name | string | Yes | No | | |
| email | string | Yes | No | email | |
| phone | string | Yes | No | | |
| comment | string | Yes | No | | |

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| tour_id | integer | Yes | No | | |
| full_name | string | Yes | No | | |
| email | string | Yes | No | | |
| phone | string | Yes | No | | |
| comment | string | Yes | No | | |
| status | string | Yes | No | | pending, answered |
| created_at | string | Yes | No | date-time | |

---

## GET /languages - Mavjud tillar

### Response Data Fields

| Field Name | Type | Required | Nullable | Format | Enum |
|---|---|---|---|---|---|
| id | integer | Yes | No | | |
| name | string | Yes | No | | |
| code | string | Yes | No | | |

---

## Legend (Alifbo)

- **Type**: Field'ning data turi (string, integer, number, boolean, object, array)
- **Required**: Agar "Yes" bo'lsa, field majburiy (request body uchun), "No" bo'lsa ixtiyoriy
- **Nullable**: Agar "Yes" bo'lsa, field `null` qiymat olishi mumkin
- **Format**: Qo'shimcha format ma'lumoti (date, date-time, email, YYYY-MM-DD va h.k.)
- **Enum**: Agar field faqat ma'lum qiymatlarni qabul qilsa, ular bu yerda ko'rsatiladi

---

## TypeScript Misol

Request body uchun:

```typescript
interface CreateReviewRequest {
  tour_id: number; // Required, not nullable
  name: string; // Required, not nullable
  email: string; // Required, not nullable, email format
  rating: number; // Required, not nullable
  comment: string; // Required, not nullable
}
```

Response uchun:

```typescript
interface Tour {
  id: number; // Required, not nullable
  slug: string; // Required, not nullable
  title: string; // Required, not nullable
  phone: string; // Required, not nullable
  description: string; // Required, not nullable
  routes: string; // Required, not nullable
  important_info: string; // Required, not nullable
  price: number; // Required, not nullable
  duration_days: number; // Required, not nullable
  duration_nights: number; // Required, not nullable
  min_age: number; // Required, not nullable
  max_people: number; // Required, not nullable
  rating: number; // Required, not nullable
  reviews_count: number; // Required, not nullable
  category: {
    id: number;
    name: string;
  }; // Required, not nullable
  main_image: string; // Required, not nullable
  images: Array<{
    id: number;
    url: string;
    is_main: boolean;
  }>; // Required, not nullable
  gif_map?: string | null; // Optional, nullable
}
```

---

**Hujjat yaratilgan: 2026-02-20**
**API Documentation Reference for Frontend Developers**
