<?php

namespace App\Pattern\Structural\Composite;

use App\Pattern\Structural\Composite\Component\FormElement;
use App\Pattern\Structural\Composite\Container\Fieldset;
use App\Pattern\Structural\Composite\Container\Form;
use App\Pattern\Structural\Composite\Leaf\Input;

class Composite
{
    /**
     * Клиентский код получает удобный интерфейс для построения сложных древовидных
     * структур.
     */
    public function getProductForm(): FormElement
    {
        $form = new Form('product', "Add product", "/product/add");
        $form->add(new Input('name', "Name", 'text'));
        $form->add(new Input('description', "Description", 'text'));

        $picture = new Fieldset('photo', "Product photo");
        $picture->add(new Input('caption', "Caption", 'text'));
        $picture->add(new Input('image', "Image", 'file'));
        $form->add($picture);

        return $form;
    }

    /**
     * Структура формы может быть заполнена данными из разных источников. Клиент не
     * должен проходить через все поля формы, чтобы назначить данные различным
     * полям, так как форма сама может справиться с этим.
     */
    public function loadProductData(FormElement $form)
    {
        $data = [
            'name' => 'Apple MacBook',
            'description' => 'A decent laptop.',
            'photo' => [
                'caption' => 'Front photo.',
                'image' => 'photo1.png',
            ],
        ];

        $form->setData($data);
    }

    /**
     * Клиентский код может работать с элементами формы, используя абстрактный
     * интерфейс. Таким образом, не имеет значения, работает ли клиент с простым
     * компонентом или сложным составным деревом.
     */
    public function renderProduct(FormElement $form): string
    {
        return $form->render();
    }
}