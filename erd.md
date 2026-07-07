# Biểu Đồ Thực Thể Liên Kết (ERD) - Hệ Thống Đặt Tour Du Lịch

Dưới đây là biểu đồ ERD (Entity-Relationship Diagram) thể hiện các thực thể chính và mối quan hệ trong cơ sở dữ liệu của hệ thống dựa trên cấu trúc hiện tại của dự án:

```mermaid
erDiagram
    USERS ||--o{ BOOKINGS : "places"
    USERS ||--o{ HOTEL_BOOKINGS : "books"
    USERS ||--o{ FLIGHT_BOOKINGS : "books"
    USERS ||--o{ COMBO_BOOKINGS : "books"
    USERS ||--o{ SERVICE_BOOKINGS : "books"
    USERS ||--o{ USER_PROMOTIONS : "claims"
    USERS ||--o{ REVIEWS : "writes"

    DESTINATIONS ||--o{ TOURS : "has"

    TOURS ||--o{ ITINERARIES : "has"
    TOURS ||--o{ BOOKINGS : "is booked in"
    TOURS ||--o{ REVIEWS : "receives"

    BOOKINGS ||--o{ PAYMENTS : "has"

    HOTELS ||--o{ HOTEL_BOOKINGS : "is booked in"
    FLIGHTS ||--o{ FLIGHT_BOOKINGS : "is booked in"
    COMBOS ||--o{ COMBO_BOOKINGS : "is booked in"
    ADDITIONAL_SERVICES ||--o{ SERVICE_BOOKINGS : "is booked in"

    PROMOTIONS ||--o{ USER_PROMOTIONS : "assigned to"

    USERS {
        int id PK
        string full_name
        string email
        string phone
        string password_hash
        string role
        string status
        string avatar
        string face_descriptor
        datetime created_at
    }

    TOURS {
        int id PK
        int destination_id FK
        string title
        string slug
        decimal price
        int duration_days
        int duration_nights
        string description
        string status
        datetime created_at
    }

    DESTINATIONS {
        int id PK
        string name
        string slug
    }

    ITINERARIES {
        int id PK
        int tour_id FK
        int day_number
        string title
        string description
    }

    BOOKINGS {
        int id PK
        int user_id FK
        int tour_id FK
        string booking_code
        date departure_date
        int total_people
        decimal total_amount
        string payment_type
        string status
    }

    PAYMENTS {
        int id PK
        int booking_id FK
        string payment_method
        string transaction_id
        decimal amount
        string payment_status
    }

    HOTELS {
        int id PK
        string name
        string address
        decimal price_per_night
    }

    HOTEL_BOOKINGS {
        int id PK
        int user_id FK
        int hotel_id FK
        string booking_code
        decimal total_price
    }

    FLIGHTS {
        int id PK
        string airline
        string flight_number
        string departure_city
        string arrival_city
        decimal price
    }

    FLIGHT_BOOKINGS {
        int id PK
        int user_id FK
        int flight_id FK
        string booking_code
        decimal total_price
    }

    COMBOS {
        int id PK
        string name
        string duration
    }

    COMBO_BOOKINGS {
        int id PK
        int user_id FK
        int combo_id FK
        string booking_code
        decimal total_price
    }

    ADDITIONAL_SERVICES {
        int id PK
        string name
        decimal price
    }

    SERVICE_BOOKINGS {
        int id PK
        int user_id FK
        int service_id FK
        string booking_code
        decimal total_price
    }

    PROMOTIONS {
        int id PK
        string code
        decimal discount_amount
    }

    USER_PROMOTIONS {
        int id PK
        int user_id FK
        int promotion_id FK
        string status
    }

    REVIEWS {
        int id PK
        int user_id FK
        int item_id FK
        int rating
        string comment
    }
```

> [!NOTE]
> - Biểu đồ này bao quát các module chính bao gồm: Người dùng, Đặt tour, Thanh toán, Khách sạn, Chuyến bay, Combo, Dịch vụ đi kèm và Khuyến mãi.
> - Các mối quan hệ đã được chuẩn hóa để phản ánh đúng cấu trúc liên kết hiện tại trong mã nguồn của bạn.
