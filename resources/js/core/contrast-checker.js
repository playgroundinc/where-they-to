class ContrastChecker {
  constructor(colors) {
    this.colors = [];
    if (colors.length) {
      colors.foreach((color) => {
        this.colors.push({ color });
      });
    }
  }
  checkContrast() {
    console.log(this.colors);
    if (this.colors.length) {
      this.colors.each()
    }
  }
}

export default ContrastChecker;