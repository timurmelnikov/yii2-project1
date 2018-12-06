<?php

namespace app\models;

use Yii;
use app\classes\Caption;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%expense_category}}".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property string $path
 * @property string $name
 * @property integer $parent_id_old
 *
 * @property Expense[] $expenses
 * @property ExpenseCategory $parent
 * @property ExpenseCategory[] $expenseCategories
 * @property ExpenseTemplate[] $expenseTemplates
 */
class ExpenseCategory extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return '{{%expense_category}}';
    }
        public function behaviors() {
        return [
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['parent_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 20],
            [['name'], 'unique'],
            [['parent_id'], 'validationCategoryMove']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'parent_id' => 'Родительская категория',
            'path' => 'Путь',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenses() {
        return $this->hasMany(Expense::className(), ['expense_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(ExpenseCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseCategories() {
        return $this->hasMany(ExpenseCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseTemplates() {
        return $this->hasMany(ExpenseTemplate::className(), ['expense_category_id' => 'id']);
    }

    /**
     * Получить parent_id 
     */
    public function getParentId() {

        $result = Self::find()
                ->where(['id' => $this->parent_id])
                ->one();
        if (isset($result->parent_id)) {
            return $result->parent_id;
        } else {
            return 0;
        }
    }

    /**
     * Получаем количество вложенных подкатегорий
     */
    public function getCountSubitems($id) {
        $result = Self::find()
                ->Where(['LIKE', 'path', trim(Self::findOne($id)['path']) == '' ? 'не ищи ничего...' : Self::findOne($id)['path'] . '.' . $this->id . '%', FALSE])
                ->count();
        return $result;
    }

    /**
     * Обновляем поле PATH текещей записи
     */
    public function updatePath() {
        $new_path = $this->parent_id;
        $id_record = $this->parent_id;
        if ($new_path != 0) {
            while (Self::findOne($id_record)->parent_id != 0) {
                $new_path = Self::findOne($id_record)->parent_id . '.' . $new_path;
                $id_record = Self::findOne($id_record)->parent_id;
            }
            $new_path = '0.' . $new_path;
        }
        $this->path = $new_path;
    }

    /**
     * Обновляем поле PATH всех записей
     */
    public function updatePathAll() {
        $a = Self::find()->all();
        foreach ($a as $row) {
            $row->save();
        }
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            $this->updatePath();
            return true;
        }
        return false;
    }

//    public function afterDelete() {
//
//        Yii::$app->getSession()->setFlash('delete-success', Caption::FLASH_DELETE_SUCCESS);
//        parent::afterDelete();
//    }
//
//    public function afterSave($insert, $changedAttributes) {
//        Yii::$app->getSession()->setFlash('save-success', Caption::FLASH_SAVE_SUCCESS);
//        parent::afterSave($insert, $changedAttributes);
//    }

    /**
     * Возвращает массив ID дочерних категорий по полю PATH
     * 
     * @return array
     */
    public static function findChildID($id = 0) {
        if ($id == 0) {
            $sql = 'SELECT ec.id FROM {{%expense_category}} ec';
        } else {
            $sql = 'SELECT ec.id FROM {{%expense_category}} ec WHERE ec.path like "' . ExpenseCategory::findOne($id)['path'] . '.' . $id . '%"';
        }
        return array_merge(ArrayHelper::getColumn(ArrayHelper::toArray(ExpenseCategory::findBySql($sql)->all()), 'id'), [$id]);
    }

    //Методы дерева*********************************************************

    /**
     * Get All categories data prepared for insert into $form->dropDownList (Возаращает иерархию категорий НОВЫЙ ВАРИАНТ)
     * 
     * @return array
     */
    public static function findAllForSelect($flag = 1, $id = 0) {

        if ($flag == 1) {
            $categoryData = self::findBySql('SELECT * FROM  {{%expense_category}} where id <> 0 order by name')->all();
        }

        if ($flag == 2) {
            $categoryData = self::findBySql('SELECT * FROM  {{%expense_category}}  order by name')->all();
        }


        if ($flag == 3) {

            $categoryData = self::findBySql('SELECT * FROM  {{%expense_category}} '
                            . 'where path not like "' . ExpenseCategory::findOne($id)->path . '.' . $id . '%"'
                            . 'and id <> ' . $id . '  order by name')->all();
        }

//        if ($flag == 3) {
//            if (ExpenseCategory::findOne($id)->parent_id == 0) {
//                $categoryData = self::findBySql('SELECT * FROM  {{%expense_category}} where path not like "' . ExpenseCategory::findOne($id)->path . '.' . $id . '%"  order by name')->all();
//            } else {
//                $categoryData = self::findBySql('SELECT * FROM  {{%expense_category}} where path not like "' . ExpenseCategory::findOne($id)->path . '.' . $id . '%"  order by name')->all();
//            }
//        }

        $categoryDataTree = self::dbResultToForest($categoryData, 'id', 'parent_id', 'name');
        $categoryDataSelect = self::converTreeArrayToSelect($categoryDataTree, 0);

        //return ArrayHelper::map($categoryDataSelect, 'id', 'name');
        return $categoryDataSelect;
    }

    /**
     * Build heriarhal result from DB Query result.
     * db result must conist id, parent_id, value
     * 
     * @param Object $rows
     * @param string $idName name of id key in result query
     * @param string $parent_idName name of parent id for query result
     * @param string $labelName name of value field in query result
     * @return array heriarhical tree
     */
    public function dbResultToForest($rows, $idName, $parent_idName, $labelName = 'label') {
        $totalArray = array();
        $children = array(); // children of each ID
        $ids = array();
        $k = 0;
        // Collect who are children of whom.
        foreach ($rows as $i => $r) {
            $element = ['id' => $rows[$i][$idName], 'parent_id' => $rows[$i][$parent_idName], 'value' => $rows[$i][$labelName]];
            $totalArray[$k++] = $element;
            $row = &$totalArray[$k - 1];
            $id = $row['id'];
            if ($id === null) {
                // Rows without an ID are totally invalid and makes the result tree to
                // be empty (because PARENT_ID = null means "a root of the tree"). So
                // skip them totally.
                continue;
            }
            $parent_id = $row['parent_id'];
            if ($id == $parent_id) {
                $parent_id = null;
            }
            $children[$parent_id][$id] = & $row;
            if (!isset($children[$id])) {
                $children[$id] = array();
            }
            $row['childNodes'] = &$children[$id];
            $ids[$id] = true;
        }

        // Root elements are elements with non-found parent_ids.
        $forest = array();
        foreach ($totalArray as $i => $r) {
            $row = &$totalArray[$i];
            $id = $row['id'];
            $parent_id = $row['parent_id'];
            if ($parent_id == $id) {
                $parent_id = null;
            }
            if (!isset($ids[$parent_id])) {
                $forest[$row[$idName]] = & $row;
            }
        }
        return $forest;
    }

    /**
     * Recursive function converting tree like array to single array with
     * delimiter. Such type of array used for generate drop down box
     * 
     * @param array $data data of tree like
     * @param int $level current level of recursive function
     * @return array converted array
     */
    public function converTreeArrayToSelect($data, $level = 0) {
        foreach ($data as $item) {
            $subitems = array();
            $elementName = "" . str_repeat("- ", $level * 2) . " " . $item['value'];
            $returnItem = array('name' => $elementName, 'id' => $item['id']);
            if ($item['childNodes']) {
                $subitems = self::converTreeArrayToSelect($item['childNodes'], $level + 1);
            }

            $returnArray[] = $returnItem;

            if ($subitems != array()) {
                $returnArray = array_merge($returnArray, $subitems);
            }
        }
        return $returnArray;
    }

    //Методы дерева (конец) *********************************************************
//Валидаторы

    /**
     * Проверка возможности перенесения в категорию
     * Защита "от дурака", ведь категории, в которые нельзя перемещать и так не отображаются.
     */
    public function validationCategoryMove($attribute, $params) {

        if (!$this->isNewRecord) {

            if ($this->id == $this->parent_id) {

                $this->addError($attribute, Caption::VALIDATION_EXPENSE_CATEGORY_MOVE_SELF);
            }
            $id = $this->parent_id;
            while ($id != 0) {
                if ($this->id == $id) {
                    $this->addError($attribute, Caption::VALIDATION_EXPENSE_CATEGORY_MOVE_CHILD);
                }
                $id = ExpenseCategory::findOne($id)->parent_id;
            }
        }
    }

}
