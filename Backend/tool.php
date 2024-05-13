<?php
class tool{
    
    // 特殊符號檢查
    function containsSpecialChars($input) {
        // 使用正則表達式檢查是否包含特殊符號
        // 如果包含特殊符號，返回 true；否則返回 false
        return preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $input);
    }
    
}
?>