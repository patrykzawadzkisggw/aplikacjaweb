const numberboxes = document.querySelectorAll(".numberbox")

numberboxes.forEach(numberbox => {
    const parent = numberbox.parentElement;
    console.log(parent);
    const minus = numberbox.querySelector(".minus")
    const plus = numberbox.querySelector(".plus")
    const val = numberbox.querySelector(".val")
    minus.addEventListener('click', _ => {
        if((parseInt(val.value)-1) >= parseInt(val.min))
        val.value=parseInt(val.value)-1;
        parent.submit()
    })

    plus.addEventListener('click', _ => {
        if((parseInt(val.value)+1) <= parseInt(val.max))
        val.value=parseInt(val.value)+1
        parent.submit()
    })

    val.addEventListener("change",_=> {
        if(parseInt(val.value)< parseInt(val.min))
            val.value=val.min
        if(parseInt(val.value)> parseInt(val.max))
            val.value=val.max
        parent.submit()
    })
})