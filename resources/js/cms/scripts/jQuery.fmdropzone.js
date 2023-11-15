(function ($) {

    $.fn.fmdropzone = function (options) {
        let self = this;

        let settings = $.extend({}, $.fn.fmdropzone.defaults, options);


        let preview = `<div class="dz-preview" ></div>`;
        let btn_delete = `<div class="dz-delete"></div>`;
        let overflow = `<div class="dz-overflow"></div>`;

        return this.each(function () {

            self.init = function () {
                // привязываем елементы
                self.dz = $(this);
                self.message = $(".dz-message", self.dz);
                self.input = $(".dz-input", self.dz);
                self.modal = $(".dz-modal", self.dz);

                if (self.input.val()) {
                    self.value = $.parseJSON(self.input.val());
                } else {
                    self.value = [];
                }

                // создаем объекты по id для каждого елемента
                let id = self.input.attr("id");

                settings.entity[id] = $.extend({}, settings, self);

                self.dz.on("click", function (event) {


                    if (
                        event.target === self.dz.get(0) ||
                        event.target === self.message.get(0)
                    ) {

                        if(settings.onModal === true ) {
                            self.createModal();
                        }

                    }
                });

                try {
                    self.makeImages(id);
                } catch (e) {
                    console.error(e);
                }
            };

            self.createModal = function () {
                $(document)
                    .find("object")
                    .remove();

                $(".modal-body", self.modal)
                    .empty()
                    .append(function () {
                        let obj = document.createElement("object");
                        return $(obj)
                            .empty()
                            .append("Server error")
                            .attr("data", $(this).data("url"))
                            .css(settings.modal);
                    });

                self.modal.modal("show");
            };


            // создаем элементы preview, img, button delete и помещем их в наружный блок dz
            self.makeImages = function (field_id) {


                try {

                    let currentObj = self.getObject(field_id);

                    if (currentObj.value.length) {

                        currentObj.value.map(function (val) {

                            // устанавливаем url по параметру item (image, thumbs)
                            // убрал из массива thumbs
                            // let url = val[currentObj.item];
                            let url = val;

                            // формируем html
                            currentObj.dz.append(function () {
                                return $(preview)
                                    .append(function () {
                                        return $(btn_delete).on("click", function (event) {
                                            event.stopPropagation();
                                            self.removeImage($(this), url, currentObj.input.attr('id'));
                                        });
                                    })
                                    .append(function () {
                                        let element = document.createElement("img");
                                        // console.table(url);
                                        $(element).attr("src", url);
                                        return $(overflow).append(element);
                                    });
                            });
                        });

                        self.messageToggle("hide", currentObj.input.attr('id'));
                    } else {
                        self.messageToggle("show", currentObj.input.attr('id'));
                    }

                } catch (e) {
                    console.error(e);
                }
            };

            //удаляем старые картинки
            self.replaceImages = function (obj) {
                let old_data = $(obj).find('.dz-preview');
                old_data.remove();
                self.makeImages(obj.input.attr('id'))
            }

            // обновляем картинки по событию window.fm_callback
            self.updateImage = function (field_id) {

                let obj = self.getObject(field_id);

                if (obj) {
                    let result = self.clearValue(field_id);

                    // console.log(result);

                    self.setObjectValue(obj, result);
                    $("#" + field_id).val(JSON.stringify(obj.value));
                    self.replaceImages(obj);
                }
            };


            // обновляем значение value у объекта
            self.setObjectValue = function (obj, result) {

                if (obj.type === 'single') {
                    let val = result[0].replace(settings.base_url, "");

                    //убрал из массива thumbs
                    // obj.value = [{
                    //     image: obj.image_base_path + val,
                    //     thumbs: obj.thumbs_base_path + val
                    // }];
                    obj.value = [ obj.image_base_path + val ];
                }

                if (obj.type === 'multiple') {
                    result.map(function (val) {

                        //убрал из массива thumbs
                        // let data = {
                        //     image: obj.image_base_path + val,
                        //     thumbs: obj.thumbs_base_path + val
                        // };
                        let data = [obj.image_base_path + val];
                        // console.table(data);
                        if (!obj.value)
                            obj.value = [];

                        obj.value.push(data);
                    })
                }
            }

            // очищаем входные данные, возвращаем массив картинок
            self.clearValue = function (field_id) {
                let value = $("#" + field_id).val();

                let searchRegExp = /[\[\]"']/gm;
                let replaceWith = "";
                value = value.replace(searchRegExp, replaceWith);
                return value.split(",");

            }


            // удаляем картинки из объекта, удаляем картинку из input value
            // idx - это или имя картинки (если убран thumbs) или индекс
            self.removeImage = function (el, idx, field_id) {

                let obj = self.getObject(field_id);

                //убрал из массива thumbs
                // let result = obj.value.filter(val => {val[obj.item] !== idx})
                // let result = obj.value.filter(val => {val[obj.item] !== idx})

                el.parent().remove();

                let result = obj.value.filter(val => val !== idx)

                if (result.length) {
                    obj.input.val(JSON.stringify(result));
                    obj.value = result;
                    self.messageToggle("hide", field_id);
                } else {
                    obj.input.val(null);
                    obj.value = null;
                    self.messageToggle("show", field_id);
                }
            };

            // скрыть - показать сообщение
            self.messageToggle = function (stat, field_id) {
                let obj = self.getObject(field_id);

                stat === "show" ? obj.message.show() : obj.message.hide();
            };

            // получаем объект по полю field_id (dz-image, dz-gallery)
            self.getObject = function (field_id) {

                // // console.log(field_id);
                // console.log(settings.entity);
                // console.log(field_id);
                // console.log(settings.entity[field_id]);


                if (typeof settings.entity[field_id] !== typeof undefined) {

                    return settings.entity[field_id];
                }

                return null;
            }

            self.init();

            // callback от file manager
            window.fm_callback = function (field_id) {

                // console.log(field_id);
                self.updateImage(field_id);
            };
            window.responsive_filemanager_callback = function (field_id){
                console.log('responsive_filemanager_callback');
                self.updateImage(field_id);
            }
            // вставляем превью youtube
            window.fm_youtube_preview = function(field_id, value){
                let obj = self.getObject(field_id);
                obj.value = [value];
                self.replaceImages(obj);
            }
        });
    };
    // console.log(window);
})(jQuery);

$.fn.fmdropzone.defaults = {
    item: "image",
    type: "single",
    modal: {width: "99%", height: "67vh"},
    entity: [],
    base_url: "",
    image_base_path: "",
    thumbs_base_path: "",
    onModal: false

};

