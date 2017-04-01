db.createUser(
    {
      user: "ustfetch",
      pwd: "fetchust",
      roles: [
         { role: "dbOwner", db: "ustfetch" }
      ]
    }
,
    {
        w: "majority",
        wtimeout: 5000
    }
);
// db.createCollection("ustfetch");