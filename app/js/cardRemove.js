const cards = document.querySelectorAll(".orders .order-light")

cards.forEach(card => {
    const btn = card.querySelector(".remove")
    btn.addEventListener("click", _=> {
        card.remove()
    })
})