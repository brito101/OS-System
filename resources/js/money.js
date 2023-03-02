$(".money_format_2").inputmask("currency", {
    autoUnmask: true,
    radixPoint: ",",
    groupSeparator: ".",
    allowMinus: false,
    prefix: "R$ ",
    digits: 2,
    digitsOptional: false,
    rightAlign: false,
    unmaskAsNumber: true,
});

$(".percentage").inputmask({
    alias:"percentage",
    radixPoint: ",",
    groupSeparator: ".",
    postfix: " %",
    integerDigits:9,
    digits:2,
    allowMinus:false,
    digitsOptional: true,
    placeholder: "0"
});


