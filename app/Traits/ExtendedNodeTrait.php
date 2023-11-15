<?php


namespace App\Traits;



use Illuminate\Http\Request;
use Kalnoy\Nestedset\NodeTrait;
use Kalnoy\Nestedset\QueryBuilder;


trait ExtendedNodeTrait
{
   use NodeTrait;

    /**
     * @return $this
     */
    public function move(){

        // данные ноды
        $node_data = request()->node ?? null;

        // новая позиция ноды - позиция начинается с 0
        $position = request()->position ?? null;

        $parent = request()->parent ?? null;

        if( $node_data ):

            // находим ноду
            $node = $this->findOrFail($node_data['id']);
            // находим родителя
            $root = $this->find($parent['id']);


            //нода перемещается как корневой элемент
            if(!$root) :
                $this->setAsRoot($node, $position);
            // нода является потомком
            elseif ($root) :
                $this->updateChild($root, $node, $position);
            endif;

        endif;


        return $this;
    }



    public function setAsRoot($node, $position)
    {
        // если нода была уже корневой
        if($node->isRoot()) :
            $roots = $this->findRoots();
            $this->moveToPosition($roots, $node, $position);
        else:
            $roots = $this->findRoots();
            $node->update(['parent_id'=>null]);
            $this->moveToPosition($roots, $node, $position);
        endif;
    }


    public function updateChild($parent, $node, $position)
    {
        $children = $this->getChildren($parent);

        $parent->appendNode($node);

        $this->moveToPosition($children, $node, $position);
    }




    public function moveChildrenBeforeDelete($node)
    {
        $children = $node->getChildren($node);

        if($children->count()){

            foreach ($children as $child){
                $child->update(['parent_id'=>null]);
            }
            $this::fixTree();
        }

        $node->refresh();
    }





    private function moveToPosition($neighbors, $node, $position)
    {
        if($position == 0) :
            // ищем самую первую и если находим, ставим нашу перед ней
            $first = $neighbors->first();
            if($first):
                $node->insertBeforeNode($first);
            endif;
        else :

            $before_position = 0;
            foreach ($neighbors as $key=>$root){
                if($root->id == $node->id)
                    $before_position = $key;
            }

            $move_up = false;
            // если новая позиция меньше предыдущей move up insert After root
            // или новая позиция больше предыдущей и позиция равна кол-ву соседей
            if($position < $before_position || ($position > $before_position && $position == $neighbors->count())){
                --$position;
                $move_up = true;
            }

            foreach ($neighbors as $key=>$neighbor) :

                if($position == $key){
                    if($move_up)
                        $node->insertAfterNode($neighbor);
                    else
                        $node->insertBeforeNode($neighbor);
                }
            endforeach;

        endif;
    }


    private function findRoots()
    {
        return $this->where('parent_id', null)->defaultOrder()->get();
    }

    public function getChildren($parent){
        return $parent->children()->defaultOrder()->get();
    }


}
