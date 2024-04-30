<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LensMark;
use App\Models\LensMarkFile;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreLensMarkRequest;
use Illuminate\Support\Facades\Log;


class LensMarkController extends Controller
{

    private $LensMark;
    private $LensMarkFile;
    public function __construct(LensMark $LensMark, LensMarkFile $LensMarkFile){
        // Laravel 의 IOC(Inversion of Control) 
        $this->LensMark = $LensMark;
        $this->LensMarkFile = $LensMarkFile;
    }

    /**
     * Display a listing of the resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query = LensMark::join('lens_mark_files', 'lens_marks.id', '=', 'lens_mark_files.mark_no')
                    ->select('lens_marks.*', 'lens_mark_files.*'); 

        if (!$request) {
            $LensMarks = $query->get();
            //Log::info('That all data');
        }else{
            //Log::info('That part of data');
            $condition = $request->input('condition');
            //Log::info('request', $request->all());
            switch ($condition) {
                case 'classification':
                    //Log::info('classification', ['classification' => $request->input('selected')]);
                    $query->where('classification', $request->input('selected'));
                    break;
                case 'manufacturer':
                    Log::info('manufacturer');
                    $query->where('manufacturer', $request->input('selected'));
                    break;
                case 'refractive_index':
                    Log::info('manufacturer');
                    $query->where('refractive_index', $request->input('selected'));
                    break;
                case 'keyword':
                    $query->where('keyword', $request->input('keyword_value'));
                    break;
                default:
                    // 예외 처리 또는 기본 동작 정의
                    break;
            }
            $LensMarks = $query->get();
            //dd('$LensMarks', $LensMarks);
        }
        return response()->json($LensMarks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLensMarkRequest $request)
    {
        try {
            $validatedData = $request->validated(); // 유효성 검사
            //dd('test : ', $validatedData);
            $lensMark = new LensMark(); // 인스턴스 생성
            $lensMark->classification = $validatedData['classification']; // 분류
            $lensMark->manufacturer = $validatedData['manufacturer']; // 제조사
            $lensMark->product_name = $validatedData['product_name']; // 제품명
            $lensMark->refractive_index = $validatedData['refractive_index']; // 굴절률
            $lensMark->keyword = $validatedData['keyword']; // 검색어
                
            if ($lensMark->save()) {
                $lensMarkFile = new LensMarkFile();
                $lensMarkFile->link = $validatedData['link']; // 제품링크
                $lensMarkFile->mark_no = $lensMark->id; // lensMark id 번호
                $lensMarkFile->created_at = now();
                
                if ($lensMarkFile->save()) {
                    return response()->json(['success' => true, 
                        'message' => 'Lens Mark and File created successfully.', 
                        'lensMark' => $lensMark->id], 200
                    );
                } else {
                    return response()->json(['success' => false, 'message' => 'Saved fail'], 500);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Lens Mark saved fail'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while saving Lens Mark and File.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $LensMark = DB::table('lens_marks')
                    ->join('lens_mark_files', 'lens_marks.id', '=', 'lens_mark_files.mark_no')
                    ->where('lens_marks.id', $id) // $id에 해당하는 레코드만 선택
                    ->select('lens_marks.*', 'lens_mark_files.product_mark1', 'lens_mark_files.product_mark2', 'lens_mark_files.link', 'lens_mark_files.mark_no')
                    ->first();

        if (!$LensMark) {
            return response()->json(['message' => 'LensMark not found'], 404);
        }
        
        return response()->json($LensMark);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreLensMarkRequest $request, $id)
    {
        try{
            $lensMark = LensMark::find($id); // 특정 LensMark를 찾습니다.
    
            if (!$lensMark) {
                return response()->json(['success' => false, 'message' => 'LensMark not found'], 404);
            }
            
            $validatedData = $request->validated(); // 유효성 검사
            $lensMark->classification = $validatedData['classification'];
            $lensMark->manufacturer = $validatedData['manufacturer'];
            $lensMark->product_name = $validatedData['product_name'];
            $lensMark->refractive_index = $validatedData['refractive_index'];
            $lensMark->keyword = $validatedData['keyword'];
            
            if ($lensMark->save()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'LensMark updated successfully',
                    'lensMark' => $id
                ], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'LensMark update failed'], 500);
            }
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while saving Lens Mark and File.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // LensMark 삭제
            $deletedLensMark = $this->LensMark->findOrFail($id);
            $deletedLensMark->delete();
    
            // LensMarkFile 삭제
            $deletedLensMarkFile = $this->LensMarkFile->where('mark_no', $id)->firstOrFail();
            $deletedLensMarkFile->delete();
    
            return response()->json(['success' => true, 'message' => 'LensMark and related LensMarkFile deleted successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while deleting LensMark and LensMarkFile.'], 500);
        }
    }

    /**
     * Display a listing of the resource.
     * 분류별 분류
     * @return \Illuminate\Http\Response
     */
    public function findClassification()
    {
        $classification = DB::table('lens_marks')
                    ->select('classification')
                    ->get();

        if (!$classification) {
            return response()->json(['message' => 'classification not found'], 404);
        }
                    
        return response()->json($classification);
    }
    /**
     * Display a listing of the resource.
     * 제조사별 분류
     * @return \Illuminate\Http\Response
     */
    public function findManufacturer()
    {
        $manufacturer = DB::table('lens_marks')
                    ->select('manufacturer')
                    ->get();

        if (!$manufacturer) {
            return response()->json(['message' => 'classification not found'], 404);
        }
                    
        return response()->json($manufacturer);
    }
    /**
     * Display a listing of the resource.
     * 굴절률별 분류
     * @return \Illuminate\Http\Response
     */
    public function findRefractiveIndex()
    {
        $refractiveIndex = DB::table('lens_marks')
                    ->select('refractive_index')
                    ->get();

        if (!$refractiveIndex) {
            return response()->json(['message' => 'classification not found'], 404);
        }
                    
        return response()->json($refractiveIndex);
    }
    /**
     * Display a listing of the resource.
     *  검색어별 분류
     * @return \Illuminate\Http\Response
     */
    public function findKeyword()       
    {
        $keyword = DB::table('lens_marks')
                    ->select('keyword')
                    ->get();

        if (!$keyword) {
            return response()->json(['message' => 'classification not found'], 404);
        }
                    
        return response()->json($keyword);
    }

    /**
     * Display a listing of the resource.
     *  검색어별 분류
     * @return \Illuminate\Http\Response
     */
    public function findByKeyword()       
    {
        $keyword = DB::table('lens_marks')
                    ->select('keyword')
                    ->get();

        if (!$keyword) {
            return response()->json(['message' => 'classification not found'], 404);
        }
                    
        return response()->json($keyword);
    }
}
