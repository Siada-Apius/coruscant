<?php

class My_View_Helper_Pagination extends Zend_View_Helper_Abstract{

    function pagination($self = ''){


        $self = ($self == '') ? 'http://' . $_SERVER['SERVER_NAME'] : $self;

        //отримуємо з роутера або параметра page поточну сторінку, якщо значення не отримується, то встановлюється - 1
        $page = (Zend_Controller_Front::getInstance()->getRequest()->getParam('page')) ? Zend_Controller_Front::getInstance()->getRequest()->getParam('page') : '1';

        //обираємо потрібну таблицю
        $db = new Application_Model_DbTable_Articles();
        //передаємо кількість елементів в пагінатор
        $paginator = Zend_Paginator::factory($db->getItemsList());
        //скільки на сторінку
        $paginator ->setItemCountPerPage(5);
        $paginator ->setCurrentPageNumber($page);

        $pages = $paginator->getPages();

        $perRange = 5;
        $range = floor($pages->current / $perRange);

        if($pages->current == $perRange * $range){
            $range = $range - 1;
        }

        $rangeFirst = $perRange * $range + 1;
        $rangeLast =  ($perRange * $range) + $perRange;

        $begin = 'Початок';
        $end = 'Остання';

        ?>

    <div class = "pagination_foot">

        <!-- Посилання на першу -->

        <?php if (isset($pages->previous)): ?>

        <a class="active" href="<?php echo $self;?>/page/<?php echo $pages->first; ?>"><?php echo $begin;?></a> |

        <?php endif; ?>
        <!-- посилання на попередню -->

        <?php if (isset($pages->previous)): ?>

        <a class="active" href="<?php echo $self;?>/page/<?php echo $pages->previous; ?>"><img class="arrow" src="/img/style/left60.jpeg"></a> |

        <?php endif; ?>

        <!-- нумеровані сторінки -->

        <?php foreach ($paginator->getPagesInRange($rangeFirst, $rangeLast) as $page): ?>

        <?php if ($page != $pages->current): ?>

            <a class="active" href="<?php echo $self;?>/page/<?php echo $page; ?>"><?php echo $page; ?></a>

            <?php else: ?>

            <?php echo $page; ?>

            <?php endif; ?>

        <?php endforeach; ?>

        <!-- наступна -->

        <?php if (isset($pages->next)): ?>

        | <a class="active" href="<?php echo $self;?>/page/<?php echo $pages->next; ?>"><img class="arrow" src="/img/style/right60.jpeg"></a> |

        <?php endif; ?>

        <!-- остання -->

        <?php if (isset($pages->next)): ?>

        <a class="active" href="<?php echo $self;?>/page/<?php echo $pages->last; ?>"><?php echo $end;?></a>

        <?php endif; ?>


    </div>

    <?php
        }
}
?>