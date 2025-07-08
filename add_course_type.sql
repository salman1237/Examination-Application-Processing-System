-- Add course_type column to courses table
ALTER TABLE `courses` ADD COLUMN `course_type` VARCHAR(20) DEFAULT 'theory' AFTER `semester`;

-- Update existing courses to have a default course type
UPDATE `courses` SET `course_type` = 'theory';

-- Add a comment explaining the purpose of this column
ALTER TABLE `courses` COMMENT = 'Course types: theory, lab, internship - Used for exam fee calculation';