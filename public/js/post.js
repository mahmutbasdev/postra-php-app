document.addEventListener('DOMContentLoaded', () => {
  const deleteForms = document.querySelectorAll('.delete-form')
  console.log(deleteForms)

  deleteForms.forEach(form => {
    form.addEventListener('submit', e => {
      e.preventDefault()
      if (confirm('Weet je zeker dat je deze post wilt verwijderen?')) {
        form.submit()
      }
    })
  })
})
