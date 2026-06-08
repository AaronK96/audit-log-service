API_KEY="audit_dev_7f4c9a2b1e8d5f3c6a9b2e1d4f8c7a3"
URL="http://127.0.0.1:8001/api/audit-events"

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-1","action":"USER_CREATED","resourceType":"User","resourceId":"user-101","serviceName":"user-service","correlationId":"corr-1001","metadata":{"email":"john.doe@example.com","role":"USER"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-1","action":"USER_ROLE_CHANGED","resourceType":"User","resourceId":"user-101","serviceName":"user-service","correlationId":"corr-1002","metadata":{"oldRole":"USER","newRole":"ADMIN","reason":"Promotion"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"user-101","action":"PASSWORD_CHANGED","resourceType":"User","resourceId":"user-101","serviceName":"auth-service","correlationId":"corr-1003","metadata":{"method":"self-service","passwordStrength":"strong"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"user-102","action":"LOGIN_SUCCESS","resourceType":"User","resourceId":"user-102","serviceName":"auth-service","correlationId":"corr-1004","metadata":{"ip":"192.168.1.15","device":"Chrome"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"user-103","action":"LOGIN_FAILED","resourceType":"User","resourceId":"user-103","serviceName":"auth-service","correlationId":"corr-1005","metadata":{"reason":"Invalid password","ip":"192.168.1.20"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"user-104","action":"ORDER_CREATED","resourceType":"Order","resourceId":"order-5001","serviceName":"order-service","correlationId":"corr-order-5001","metadata":{"amount":149.99,"currency":"EUR"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"system","action":"PAYMENT_RECEIVED","resourceType":"Order","resourceId":"order-5001","serviceName":"billing-service","correlationId":"corr-order-5001","metadata":{"provider":"Stripe","transactionId":"txn-123456"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"system","action":"STOCK_RESERVED","resourceType":"Order","resourceId":"order-5001","serviceName":"inventory-service","correlationId":"corr-order-5001","metadata":{"warehouse":"WH-01","items":3}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"system","action":"EMAIL_SENT","resourceType":"Order","resourceId":"order-5001","serviceName":"notification-service","correlationId":"corr-order-5001","metadata":{"template":"order-confirmation","recipient":"john.doe@example.com"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-2","action":"API_KEY_CREATED","resourceType":"ApiKey","resourceId":"key-001","serviceName":"admin-panel","correlationId":"corr-1006","metadata":{"keyName":"User Service Key","createdBy":"admin-2"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-2","action":"API_KEY_ROTATED","resourceType":"ApiKey","resourceId":"key-001","serviceName":"admin-panel","correlationId":"corr-1007","metadata":{"oldKeyId":"key-001","newKeyId":"key-002"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-2","action":"USER_DISABLED","resourceType":"User","resourceId":"user-105","serviceName":"user-service","correlationId":"corr-1008","metadata":{"reason":"Too many failed logins"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-2","action":"USER_ENABLED","resourceType":"User","resourceId":"user-105","serviceName":"user-service","correlationId":"corr-1009","metadata":{"enabledBy":"admin-2"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"user-106","action":"PROFILE_UPDATED","resourceType":"User","resourceId":"user-106","serviceName":"user-service","correlationId":"corr-1010","metadata":{"changedFields":["email","phone"]}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-3","action":"DATA_EXPORT_STARTED","resourceType":"Report","resourceId":"report-2001","serviceName":"report-service","correlationId":"corr-export-1","metadata":{"exportType":"users"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-3","action":"DATA_EXPORT_COMPLETED","resourceType":"Report","resourceId":"report-2001","serviceName":"report-service","correlationId":"corr-export-1","metadata":{"fileSize":"12MB","rows":1500}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"system","action":"INVOICE_CREATED","resourceType":"Invoice","resourceId":"invoice-9001","serviceName":"billing-service","correlationId":"corr-billing-1","metadata":{"amount":149.99,"currency":"EUR"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"system","action":"INVOICE_PAID","resourceType":"Invoice","resourceId":"invoice-9001","serviceName":"billing-service","correlationId":"corr-billing-1","metadata":{"paymentMethod":"Credit Card","provider":"Stripe"}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"admin-4","action":"PERMISSION_UPDATED","resourceType":"Role","resourceId":"role-admin","serviceName":"admin-panel","correlationId":"corr-1011","metadata":{"permission":"user.delete","granted":true}}'

curl -X POST "$URL" -H "Content-Type: application/json" -H "X-API-Key: $API_KEY" -d '{"actorId":"system","action":"ORDER_CANCELLED","resourceType":"Order","resourceId":"order-5002","serviceName":"order-service","correlationId":"corr-order-5002","metadata":{"cancellationReason":"Customer request"}}'

echo "20 Audit Events erstellt."