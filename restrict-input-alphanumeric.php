<script>

$(document)
  .on('keydown', '.alpha', function(e) {
    var a = e.key;
    if (a.length == 1) return /[a-z]|\$|#|\*/i.test(a);
    return true;
  })
  .on('keydown', '.numeric', function(e) {
    var a = e.key;
    if (a.length == 1) return /[0-9]|\+|-/.test(a);
    return true;
  })
  .on('keydown', '.alphanumeric', function(e) {
    var a = e.key;
    if (a.length == 1) return /^[a-z0-9]+$/i.test(a);
    return true;
  })

$(document).ready(function() {
  $('.alphanumeric').on("cut copy paste", function(e) {
    e.preventDefault();
  });
});
</script>
