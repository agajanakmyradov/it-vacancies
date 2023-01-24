<?php

namespace App\Filters;

class Jobfilter extends QueryFilter{
    /*
    public function category_id($id = null){
        return $this->builder->when($id, function($query) use($id){
            $query->where('category_id', $id);
        });
    }
    */

    public function city($city = null){
        return $this->builder->when($city, function($query) use ($city){
            $query->where('city', $city);
        });
    }

    public function salary($salary = null){
        return $this->builder->when($salary, function($query) use ($salary){
            $query->where('salary', '>=', $salary);
        });
    }

    public function experience($experience = null){
        return $this->builder->when($experience, function($query) use ($experience){
            $query->where('experience', '>=', $experience);
        });
    }
    
    
    public function category_id($category_id = ''){
        return $this->builder->when($category_id, function($query) use ($category_id){
            $query->where('category_id', $category_id);
        });
    }
    
}
