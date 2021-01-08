class Component{
    constructor(container){
        this.container = container;
    }
    render(markup){
        this.container.innerHTML = markup;
    };
    getChild(selectors){
        return this.container.querySelector(selectors);
    }
    addEventListener(type, callback){
        this.container.addEventListener(type, callback);
    }
}