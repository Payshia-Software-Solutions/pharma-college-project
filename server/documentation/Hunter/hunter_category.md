# Hunter Category API Documentation

## Endpoints

### 1. Get All Categories
- **URL:** `/hunter-category/`
- **Method:** `GET`
- **Description:** Retrieve all hunter categories.
- **Response:**
  - Status: `200 OK`
  - Body: JSON array of category records.

### 2. Get Category by ID
- **URL:** `/hunter-category/{id}/`
- **Method:** `GET`
- **Description:** Retrieve a single category by its ID.
- **Path Parameters:**
  - `id` (int): The ID of the category.
- **Response:**
  - Status: `200 OK`
  - Body: JSON object representing the category.
  - Status: `404 Not Found`
  - Body: `{ "error": "Record not found" }`

### 3. Create a New Category
- **URL:** `/hunter-category/`
- **Method:** `POST`
- **Description:** Create a new category.
- **Request Body:**
  - `category_name` (string): The name of the category.
  - `active_status` (string): The status of the category.
  - `created_by` (string): The creator of the category.
- **Response:**
  - Status: `201 Created`
  - Body: `{ "message": "Record created successfully" }`

### 4. Update a Category
- **URL:** `/hunter-category/{id}/`
- **Method:** `PUT`
- **Description:** Update an existing category.
- **Path Parameters:**
  - `id` (int): The ID of the category to update.
- **Request Body:**
  - `category_name` (string): The new name of the category.
  - `active_status` (string): The new status of the category.
  - `created_by` (string): The new creator of the category.
- **Response:**
  - Status: `200 OK`
  - Body: `{ "message": "Record updated successfully" }`

### 5. Delete a Category
- **URL:** `/hunter-category/{id}/`
- **Method:** `DELETE`
- **Description:** Delete a category by its ID.
- **Path Parameters:**
  - `id` (int): The ID of the category to delete.
- **Response:**
  - Status: `200 OK`
  - Body: `{ "message": "Record deleted successfully" }`
