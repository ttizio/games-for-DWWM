const express = require("express");
const port = 5000;
const app = express();

app.get("/post", (req, res) => {
    res.json({ message:"voici les donnés" });
});

app.listen(port, () => console.log(`Le serveur a demarré au port ` + port));