document.addEventListener('DOMContentLoaded', function(){
  let checkboxes = document.querySelectorAll('input[name="course[]"]');
  let totalSKS = document.getElementById('totalSKS');

  checkboxes.forEach(cb => {
    cb.addEventListener('change', () => {
      let total = 0;
      checkboxes.forEach(c => {
        if(c.checked) total += parseInt(c.dataset.sks);
      });
      totalSKS.textContent = total;
    });
  });

  // form submit tanpa refresh
  document.getElementById('enrollForm').addEventListener('submit', function(e){
    e.preventDefault();
    let formData = new FormData(this);

    fetch('/student/enroll', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      document.getElementById('result').innerHTML = data.message;
    });
  });
});
