const domain                = document.location.origin;
const domainpath            = "";
const token                 = $("meta[name=csrf-token]").attr("content");
const moneyformatter        = $("#moneyformatter").html();
const success               = $("#success").val();
const error                 = $("#error").val();
const spinner               = $("#loader"); 