# Swagger API Dokumentatsiyasi

## Swagger UI ni Ko'rish

Brauzerda ochish:

```
http://localhost/api/documentation
```

yoki

```
http://travel.test/api/documentation
```

## Swagger Qayta Generatsiya Qilish

Controllerlarni o'zgartirganingizdan keyin:

```bash
php artisan l5-swagger:generate
```

## API Endpointlar

- `GET /api/languages` - Mavjud tillar ro'yxati
- `GET /api/faq` - Ko'p beriladigan savollar
- `GET /api/about` - Biz haqimizda
- `GET /api/contact` - Bog'lanish
- `GET /api/hero-slides` - Bosh sahifa slaydlar

## Tilni Header Orqali Yuborish

Barcha endpointlar `Accept-Language` header orqali tilni qabul qiladi:

```bash
# Curl bilan
curl http://localhost/api/faq -H "Accept-Language: uz"
curl http://localhost/api/faq -H "Accept-Language: ru"
curl http://localhost/api/faq -H "Accept-Language: en"

# JavaScript Fetch bilan
fetch('/api/faq', {
  headers: {
    'Accept-Language': 'uz'
  }
});

# Axios bilan
axios.get('/api/faq', {
  headers: {
    'Accept-Language': 'ru'
  }
});
```

Default til: `uz`

## Response Format

Ma'lumotlar to'g'ridan-to'g'ri obyekt ko'rinishida qaytariladi (translations array bo'lib kelmaydi):

```json
{
  "success": true,
  "data": {
    "id": 1,
    "title": "Sarlavha",
    "description": "Tavsif"
  }
}
```

## JSON Faylni Ko'rish

```
http://localhost/docs/api-docs.json
```

## Mavjud Tillarni Olish

Frontend dasturchilar mavjud tillarni olish uchun:

```bash
curl http://localhost/api/languages
```

Response:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "O'zbekcha",
      "code": "uz"
    },
    {
      "id": 2,
      "name": "Русский",
      "code": "ru"
    }
  ]
}
```

Bu endpoint languages jadvalidan faol tillarni qaytaradi.
