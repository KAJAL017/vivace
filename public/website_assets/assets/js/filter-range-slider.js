const onInput = (parent, e) => {
    const slides = parent.querySelectorAll("input");
    const min = parseFloat(slides[0].min);
    const max = parseFloat(slides[1].max);

    let slide1 = parseFloat(slides[0].value);
    let slide2 = parseFloat(slides[1].value);

    const percentageMin = (slide1 / (max - min)) * 100;
    const percentageMax = (slide2 / (max - min)) * 100;

    parent.style.setProperty("--range-slider-value-low", percentageMin);
    parent.style.setProperty("--range-slider-value-high", percentageMax);

    if (slide1 > slide2) {
      const tmp = slide2;
      slide2 = slide1;
      slide1 = tmp;

      if (e?.currentTarget === slides[0]) {
        slides[0].insertAdjacentElement("beforebegin", slides[1]);
      } else {
        slides[1].insertAdjacentElement("afterend", slides[0]);
      }
    }

    // Format numbers with commas and add ₹ symbol
    const formatPrice = (value) => {
        return "₹" + new Intl.NumberFormat('en-IN').format(value);
    };

    const displayElement = parent.querySelector(".range-slider-display");
    if (displayElement) {
      displayElement.setAttribute("data-low", formatPrice(slide1));  // Add formatted price here
      displayElement.setAttribute("data-high", formatPrice(slide2)); // Add formatted price here
    }
};


  addEventListener("DOMContentLoaded", (event) => {
    document.querySelectorAll(".range-slider").forEach((range) =>
      range.querySelectorAll("input").forEach((input) => {
        if (input.type === "range") {
          input.oninput = (e) => onInput(range, e);
          onInput(range);
        }
      })
    );
  });
