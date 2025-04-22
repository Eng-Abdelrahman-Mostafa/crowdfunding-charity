# Charity Platform Authentication API Documentation

This document provides information about the authentication API endpoints for the Charity Platform.

## Base URL

All API endpoints are prefixed with `/api`.

## Authentication

The API uses token-based authentication via Laravel Sanctum. After successful login or registration, you will receive a token that should be included in subsequent requests as an Authorization header:

```
Authorization: Bearer {your-token}
```

## Endpoints

### Register

Creates a new user account.

- **URL**: `/api/auth/register`
- **Method**: `POST`
- **Authentication**: Not required

**Request Body:**

```json
{
  "name": "User Name",
  "email": "user@example.com",
  "phone": "1234567890",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Response (201 Created):**

```json
{
  "status": "success",
  "message": "User registered successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "User Name",
      "email": "user@example.com",
      "phone": "1234567890",
      "type": "donor",
      "status": "active",
      "created_at": "2023-06-15T12:00:00.000000Z",
      "updated_at": "2023-06-15T12:00:00.000000Z"
    },
    "token": "your-auth-token"
  }
}
```

### Login

Authenticates a user and returns a token.

- **URL**: `/api/auth/login`
- **Method**: `POST`
- **Authentication**: Not required

**Request Body:**

```json
{
  "email": "user@example.com",
  "password": "password123",
  "remember_me": true
}
```

**Response (200 OK):**

```json
{
  "status": "success",
  "message": "User logged in successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "User Name",
      "email": "user@example.com",
      "phone": "1234567890",
      "type": "donor",
      "status": "active",
      "created_at": "2023-06-15T12:00:00.000000Z",
      "updated_at": "2023-06-15T12:00:00.000000Z"
    },
    "token": "your-auth-token"
  }
}
```

### Logout

Revokes the current user's token.

- **URL**: `/api/auth/logout`
- **Method**: `POST`
- **Authentication**: Required

**Response (200 OK):**

```json
{
  "status": "success",
  "message": "User logged out successfully"
}
```

### Get User Profile

Retrieves the authenticated user's profile information.

- **URL**: `/api/auth/profile`
- **Method**: `GET`
- **Authentication**: Required

**Response (200 OK):**

```json
{
  "status": "success",
  "data": {
    "user": {
      "id": 1,
      "name": "User Name",
      "email": "user@example.com",
      "phone": "1234567890",
      "type": "donor",
      "status": "active",
      "created_at": "2023-06-15T12:00:00.000000Z",
      "updated_at": "2023-06-15T12:00:00.000000Z"
    }
  }
}
```

### Forgot Password

Sends a password reset link to the user's email.

- **URL**: `/api/auth/forgot-password`
- **Method**: `POST`
- **Authentication**: Not required

**Request Body:**

```json
{
  "email": "user@example.com"
}
```

**Response (200 OK):**

```json
{
  "status": "success",
  "message": "We have emailed your password reset link!"
}
```

### Reset Password

Resets a user's password using a token.

- **URL**: `/api/auth/reset-password`
- **Method**: `POST`
- **Authentication**: Not required

**Request Body:**

```json
{
  "token": "password-reset-token",
  "email": "user@example.com",
  "password": "new-password",
  "password_confirmation": "new-password"
}
```

**Response (200 OK):**

```json
{
  "status": "success",
  "message": "Your password has been reset!"
}
```

### Change Password

Changes the authenticated user's password.

- **URL**: `/api/auth/change-password`
- **Method**: `POST`
- **Authentication**: Required

**Request Body:**

```json
{
  "current_password": "current-password",
  "password": "new-password",
  "password_confirmation": "new-password"
}
```

**Response (200 OK):**

```json
{
  "status": "success",
  "message": "Password changed successfully"
}
```

## Social Authentication

The API supports authentication with Google and Facebook.

### Get OAuth Redirect URL

Retrieves the URL to redirect to for OAuth authentication.

- **URL**: `/api/auth/redirect/{provider}`
- **Method**: `GET`
- **Parameters**:
  - `provider`: The OAuth provider (google or facebook)
- **Authentication**: Not required

**Response (200 OK):**

```json
{
  "status": "success",
  "url": "https://accounts.google.com/o/oauth2/auth?client_id=..."
}
```

### Handle OAuth Callback

Processes the OAuth callback and authenticates the user.

- **URL**: `/api/auth/callback/{provider}`
- **Method**: `POST`
- **Parameters**:
  - `provider`: The OAuth provider (google or facebook)
- **Authentication**: Not required

**Request Body:**

```json
{
  "access_token": "oauth-access-token",
  "token_secret": "oauth-token-secret" 
}
```

**Response (200 OK):**

```json
{
  "status": "success",
  "message": "User logged in successfully",
  "data": {
    "user": {
      "id": 1,
      "name": "User Name",
      "email": "user@example.com",
      "phone": "1234567890",
      "social_id": "social-provider-id",
      "social_type": "google",
      "social_avatar": "https://example.com/avatar.jpg",
      "type": "donor",
      "status": "active",
      "created_at": "2023-06-15T12:00:00.000000Z",
      "updated_at": "2023-06-15T12:00:00.000000Z"
    },
    "token": "your-auth-token"
  }
}
```

## Error Responses

All endpoints return error responses in the following format:

```json
{
  "status": "error",
  "message": "Error message",
  "errors": {
    "field": [
      "Error description"
    ]
  }
}
```

Status codes:
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error
- 500: Server Error

## Integration with Frontend

### Web Application

For a web application, you can use the API as follows:

1. For regular login/registration, make a POST request to the appropriate endpoint.
2. For social login:
   - Use the `/api/auth/redirect/{provider}` endpoint to get the OAuth URL.
   - Redirect the user to that URL.
   - After authentication, the provider will redirect back to your application.
   - Extract the access token and call `/api/auth/callback/{provider}` to complete the authentication.

### Mobile Application

For a mobile application, you typically need to use the provider's SDK:

1. Use the SDK to authenticate with the provider and get an access token.
2. Send that access token to `/api/auth/callback/{provider}` to authenticate with your API.

## Environment Configuration

Make sure to set the following environment variables in your `.env` file:

```
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI="${APP_URL}/api/auth/callback/google"

FACEBOOK_CLIENT_ID=your-facebook-client-id
FACEBOOK_CLIENT_SECRET=your-facebook-client-secret
FACEBOOK_REDIRECT_URI="${APP_URL}/api/auth/callback/facebook"
```
