require('./popup.less');
export default class Popup
{
    constructor(route, id, data = null)
    {
        this.route = route;
        this.id = id;
        this.data = data;
        this.content = '';
        this.events();
    }

    getContent()
    {
        $.ajax({
            type: 'post',
            url: '/ajax/' + this.route + '/' + this.id,
            data: this.data,
            success: (response) => {
                this.render(response)
            }
        });
    }

    events()
    {
        $(document).on('click', '.popup-shadow', () => {
            this.close();
        });
    }

    close()
    {
        $('.popup-shadow').hide();
        $('.popup').hide(300);
    }

    render(content)
    {
        $('.popup').show(300).html(content);
        $('.popup-shadow').show();
    }
}