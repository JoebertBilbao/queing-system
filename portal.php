function isStepReached($step) {
    global $conn;
    
    $valid_steps = ['step 2', 'step 3', 'step 4', 'step 5', 'step 6', 'step 7', 'Completed'];
    
    if (!in_array($step, $valid_steps)) {
        return false;
    }
    
    $sql = "SELECT COUNT(*) as count FROM users WHERE step_status = ? OR step_status IN (
        SELECT step_status FROM (
            SELECT 'step 3' as step_status
            UNION SELECT 'step 4'
            UNION SELECT 'step 5'
            UNION SELECT 'step 6'
            UNION SELECT 'step 7'
            UNION SELECT 'Completed'
        ) AS steps
        WHERE FIND_IN_SET(step_status, 'step 2,step 3,step 4,step 5,step 6,step 7,Completed') 
              >= FIND_IN_SET(?, 'step 2,step 3,step 4,step 5,step 6,step 7,Completed')
    )";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $step, $step);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}
