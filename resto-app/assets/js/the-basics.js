var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
};


// retrieved from transaction view. evaluated as array - item names
var products = eval($('#json_list_products').html());

$('#the-basics-products .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'products',
  source: substringMatcher(products)
});

// retrieved from transaction view. evaluated as array - customer names
var customers = eval($('#json_list_customers').html());

$('#the-basics-customers .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'customers',
  source: substringMatcher(customers)
});