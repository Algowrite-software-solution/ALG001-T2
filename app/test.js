const data = {
  validatable_type1: [
    {
      datakey: "data1",
      value: "12423",
    },
    {
      datakey: "data2",
      value: "12423",
    },
    {
      datakey: "data3",
      value: "text",
    },
  ],
  validatable_type2: [
    { datakey: "myEmail", value: "myemail@gmail.com" },
    { datakey: "yourEmail", value: "not an email" },
  ],
};

console.log(JSON.stringify(data));
