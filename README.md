## READ ME

1. Create database schema from mysql workbench named "esb"
2. Use terminal for data migration -> php yii migrate -> yes
3. To start application, use terminal -> php yii serve
4. Go to browser, and type http://localhost:8080
5. You can access API through Postman API Collection File ESB Test.postman_collection.json

### Postman Collection

- Create Invoice: creates invoice by inserting invoice data and details
  url: http://localhost:8080/api/invoice/create-invoice
  method: POST
  example:
  {
  "issue_date" : "yyyy-mm-dd",
  "due_date" : "yyyy-mm-dd",
  "subject" : "<<subject>>",
  "user_id" : "<<user_id>>",
  "subtotal" : <<subtotal>>,
  "tax" : <<tax>>,
  "payments": <<payments>>,
  "customer_name": "<<customer_name>>",
  "detail_address" : "<<detail_address>>",
  "invoiceDetails" : [
  {
  "item_type" : "<<item_type>>",
  "description" : "<<description>>",
  "quantity" : <<quantity>>,
  "unit_price" : <<unit_price>>,
  "amount" : <<amount>>
  },
  {
  "item_type" : "<<item_type>>",
  "description" : "<<description>>",
  "quantity" : <<quantity>>,
  "unit_price" : <<unit_price>>,
  "amount" : <<amount>>
  }
  ]
  }
- Get Invoice: get all invoice (body none) or entering specific invoice by id
  url: http://localhost:8080/api/invoice/get-invoice
  method: GET
  example:
  {
  "id" : <<id>>
  }
- Update Invoice: updates specific invoice by id, inserting data and details
  url: http://localhost:8080/api/invoice/update-invoice
  method: PUT
  example:
  {
  "id" : <<id>>,
  "issue_date" : "yyyy-mm-dd",
  "due_date" : "yyyy-mm-dd",
  "subject" : "<<subject>>",
  "user_id" : "<<user_id>>",
  "subtotal" : <<subtotal>>,
  "tax" : <<tax>>,
  "payments": <<payments>>,
  "customer_name": "<<customer_name>>",
  "detail_address" : "<<detail_address>>",
  "invoiceDetails" : [
  {
  "item_type" : "<<item_type>>",
  "description" : "<<description>>",
  "quantity" : <<quantity>>,
  "unit_price" : <<unit_price>>,
  "amount" : <<amount>>
  },
  {
  "item_type" : "<<item_type>>",
  "description" : "<<description>>",
  "quantity" : <<quantity>>,
  "unit_price" : <<unit_price>>,
  "amount" : <<amount>>
  }
  ]
  }
- Delete Invoice: deleting specific invoice by id
  url: http://localhost:8080/api/invoice/delete-invoice
  method: DELETE
  example:
  {
  "id" : 1
  }
- Print Invoice: print specific invoice by id
  url: http://localhost:8080/invoice/print/1
  method: GET
