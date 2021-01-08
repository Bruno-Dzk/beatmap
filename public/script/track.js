class Track extends Component{
    constructor(container, id, title, artists, imgSrc){
        super(container);
        this.render(Track.markup(title, artists, imgSrc));
        this.id = id;
        this.title = title;
        this.artists = artists;
        this.imgSrc = imgSrc;
    }
    toggleSelected(){
        this.container.classList.toggle("track-selected");
    }
    static markup(title, artists, imgSrc){
        return `
            <img width="64" height="64" src="${imgSrc}">
            <div class="track-desc">
                <h1 class="track-title">
                    ${title}
                </h1>
                <h2 class="track-artists">
                    ${artists}
                </h2>
                <p class="track-selected-label">
                    SELECTED
                </p>
            </div>`
    }
}