const express = require('express');
const bodyParser = require('body-parser');
const app = express();

app.use(bodyParser.json());

app.post('/razorpay-webhook', (req, res) => {
    console.log('Webhook received:', req.body);
    res.status(200).send('Webhook received');
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
    console.log(`Server running on port ${PORT}`);
});