<?php
namespace app\logic;

use app\model\CourseVideo as CourseVideoModel;

class CourseVideo extends CourseVideoModel
{
    //获取当前章节的课程ID&&章节ID
    public function getCourseOrChapter($videoId)
    {
        $chapterId = $this->getCourseVideoInfo($videoId, 'chapter_id');
        $courseId  = (new Chapter())->getChapterInfo($chapterId['chapter_id'], 'course_id');

        return [
            'chapter_id' => $chapterId['chapter_id'],
            'course_id' => $courseId['course_id'],
        ];

    }

    //
    public function selectCourseList($videoInfo)
    {

        $data = (new Course())->field('id,title')->where('delete_status', 0)->select()->toArray();

        foreach ($data as $key => $value)
        {

            if ($value['id'] == $videoInfo['course_id'])
            {
                $value['select'] = 1;
            }
            else
            {
                $value['select'] = 0;
            }
            $data[$key] = $value;
        }

        return $data;
    }

    //
    public function selectChapterList($videoInfo)
    {

        $data = (new Chapter())->field('id,title')->where('delete_status', 0)->select();
        foreach ($data as $key => $value)
        {

            if ($value['id'] == $videoInfo['chapter_id'])
            {
                $value['select'] = 1;
            }
            else
            {
                $value['select'] = 0;
            }
            $data[$key] = $value;
        }

        return $data;
        
    }

}
