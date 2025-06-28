<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Format Converter</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }
        
        .header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .header h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .header p {
            color: #666;
            font-size: 1.1em;
        }
        
        .upload-section {
            border: 3px dashed #667eea;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            transition: all 0.3s ease;
            background: rgba(102, 126, 234, 0.05);
        }
        
        .upload-section:hover {
            border-color: #764ba2;
            background: rgba(118, 75, 162, 0.05);
        }
        
        .upload-section.dragover {
            border-color: #764ba2;
            background: rgba(118, 75, 162, 0.1);
            transform: scale(1.02);
        }
        
        .upload-icon {
            font-size: 4em;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .file-input {
            display: none;
        }
        
        .upload-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.1em;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px;
        }
        
        .upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        
        .options-section {
            display: none;
            margin-bottom: 30px;
        }
        
        .option-group {
            margin-bottom: 25px;
        }
        
        .option-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 1.1em;
        }
        
        .format-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .format-option {
            position: relative;
        }
        
        .format-option input[type="radio"] {
            display: none;
        }
        
        .format-option label {
            display: block;
            padding: 15px;
            border: 2px solid #ddd;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            font-weight: 600;
            color: #666;
        }
        
        .format-option input[type="radio"]:checked + label {
            border-color: #667eea;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .quality-slider {
            width: 100%;
            height: 8px;
            border-radius: 5px;
            background: #ddd;
            outline: none;
            -webkit-appearance: none;
            margin: 10px 0;
        }
        
        .quality-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }
        
        .quality-slider::-moz-range-thumb {
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }
        
        .quality-display {
            text-align: center;
            font-size: 1.2em;
            font-weight: 600;
            color: #667eea;
            margin-top: 10px;
        }
        
        .convert-btn {
            width: 100%;
            padding: 20px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 15px;
            font-size: 1.2em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }
        
        .convert-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .convert-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .preview-section {
            display: none;
            margin-top: 30px;
        }
        
        .preview-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .preview-item {
            text-align: center;
            padding: 20px;
            border-radius: 15px;
            background: rgba(102, 126, 234, 0.05);
        }
        
        .preview-item h3 {
            margin-bottom: 15px;
            color: #333;
        }
        
        .preview-item img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .download-btn {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 20px;
        }
        
        .download-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
        }
        
        .progress-bar {
            display: none;
            width: 100%;
            height: 10px;
            background: #ddd;
            border-radius: 5px;
            overflow: hidden;
            margin: 20px 0;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            width: 0%;
            transition: width 0.3s ease;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        .error-message {
            display: none;
            background: #ff4757;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        
        .success-message {
            display: none;
            background: #2ed573;
            color: white;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            .container { padding: 20px; }
            .header h1 { font-size: 2em; }
            .preview-grid { grid-template-columns: 1fr; }
            .format-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎨 Image Format Converter</h1>
            <p>Convert your images between different formats with custom quality settings</p>
        </div>
        
        <form id="converterForm" method="post" enctype="multipart/form-data">
            <div class="upload-section" id="uploadSection">
                <div class="upload-icon">📁</div>
                <h3>Drop your image here or click to browse</h3>
                <p>Supports: JPG, PNG, GIF, WEBP, BMP, TIFF</p>
                <input type="file" id="imageFile" name="image" class="file-input" accept="image/*" required>
                <button type="button" class="upload-btn" onclick="document.getElementById('imageFile').click()">
                    Choose Image
                </button>
            </div>
            
            <div class="options-section" id="optionsSection">
                <div class="option-group">
                    <label>Select Output Format:</label>
                    <div class="format-grid">
                        <div class="format-option">
                            <input type="radio" id="jpg" name="format" value="jpg" checked>
                            <label for="jpg">JPG</label>
                        </div>
                        <div class="format-option">
                            <input type="radio" id="png" name="format" value="png">
                            <label for="png">PNG</label>
                        </div>
                        <div class="format-option">
                            <input type="radio" id="gif" name="format" value="gif">
                            <label for="gif">GIF</label>
                        </div>
                        <div class="format-option">
                            <input type="radio" id="webp" name="format" value="webp">
                            <label for="webp">WEBP</label>
                        </div>
                        <div class="format-option">
                            <input type="radio" id="bmp" name="format" value="bmp">
                            <label for="bmp">BMP</label>
                        </div>
                    </div>
                </div>
                
                <div class="option-group">
                    <label>Image Quality (%):</label>
                    <input type="range" id="qualitySlider" name="quality" min="10" max="100" value="85" class="quality-slider">
                    <div class="quality-display" id="qualityDisplay">85%</div>
                </div>
                
                <button type="submit" class="convert-btn" id="convertBtn">
                    🔄 Convert Image
                </button>
            </div>
        </form>
        
        <div class="progress-bar" id="progressBar">
            <div class="progress-fill" id="progressFill"></div>
        </div>
        
        <div class="error-message" id="errorMessage"></div>
        <div class="success-message" id="successMessage"></div>
        
        <div class="preview-section" id="previewSection">
            <div class="preview-grid">
                <div class="preview-item">
                    <h3>Original Image</h3>
                    <img id="originalPreview" src="" alt="Original">
                    <p id="originalInfo"></p>
                </div>
                <div class="preview-item">
                    <h3>Converted Image</h3>
                    <img id="convertedPreview" src="" alt="Converted">
                    <p id="convertedInfo"></p>
                    <a href="#" id="downloadBtn" class="download-btn" download>
                        ⬇️ Download Converted Image
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File input and drag & drop functionality
        const uploadSection = document.getElementById('uploadSection');
        const fileInput = document.getElementById('imageFile');
        const optionsSection = document.getElementById('optionsSection');
        const qualitySlider = document.getElementById('qualitySlider');
        const qualityDisplay = document.getElementById('qualityDisplay');
        const form = document.getElementById('converterForm');
        const progressBar = document.getElementById('progressBar');
        const progressFill = document.getElementById('progressFill');
        const errorMessage = document.getElementById('errorMessage');
        const successMessage = document.getElementById('successMessage');
        const previewSection = document.getElementById('previewSection');

        // Update quality display
        qualitySlider.addEventListener('input', function() {
            qualityDisplay.textContent = this.value + '%';
        });

        // Drag and drop functionality
        uploadSection.addEventListener('dragover', function(e) {
            e.preventDefault();
            uploadSection.classList.add('dragover');
        });

        uploadSection.addEventListener('dragleave', function(e) {
            e.preventDefault();
            uploadSection.classList.remove('dragover');
        });

        uploadSection.addEventListener('drop', function(e) {
            e.preventDefault();
            uploadSection.classList.remove('dragover');
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelect();
            }
        });

        // File selection handler
        fileInput.addEventListener('change', handleFileSelect);

        function handleFileSelect() {
            const file = fileInput.files[0];
            if (file) {
                // Show options section
                optionsSection.style.display = 'block';
                
                // Show original preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('originalPreview').src = e.target.result;
                    document.getElementById('originalInfo').textContent = 
                        `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                };
                reader.readAsDataURL(file);
            }
        }

        // Form submission
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('image', fileInput.files[0]);
            formData.append('format', document.querySelector('input[name="format"]:checked').value);
            formData.append('quality', qualitySlider.value);
            
            // Show progress bar
            progressBar.style.display = 'block';
            progressFill.style.width = '30%';
            
            // Hide previous messages
            errorMessage.style.display = 'none';
            successMessage.style.display = 'none';
            
            fetch('convert.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                progressFill.style.width = '70%';
                return response.json();
            })
            .then(data => {
                progressFill.style.width = '100%';
                
                setTimeout(() => {
                    progressBar.style.display = 'none';
                    progressFill.style.width = '0%';
                    
                    if (data.success) {
                        // Show success message
                        successMessage.textContent = 'Image converted successfully!';
                        successMessage.style.display = 'block';
                        
                        // Show converted preview
                        document.getElementById('convertedPreview').src = data.converted_image;
                        document.getElementById('convertedInfo').textContent = 
                            `${data.filename} (${data.size})`;
                        document.getElementById('downloadBtn').href = data.converted_image;
                        document.getElementById('downloadBtn').download = data.filename;
                        
                        previewSection.style.display = 'block';
                    } else {
                        throw new Error(data.message || 'Conversion failed');
                    }
                }, 500);
            })
            .catch(error => {
                progressBar.style.display = 'none';
                progressFill.style.width = '0%';
                errorMessage.textContent = error.message || 'An error occurred during conversion';
                errorMessage.style.display = 'block';
            });
        });
    </script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    
    try {
        // Check if file was uploaded
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('No file uploaded or upload error occurred');
        }
        
        $uploadedFile = $_FILES['image'];
        $targetFormat = strtolower($_POST['format'] ?? 'jpg');
        $quality = intval($_POST['quality'] ?? 85);
        
        // Validate quality
        if ($quality < 10 || $quality > 100) {
            $quality = 85;
        }
        
        // Get file info
        $originalName = pathinfo($uploadedFile['name'], PATHINFO_FILENAME);
        $uploadPath = $uploadedFile['tmp_name'];
        
        // Create output directory if it doesn't exist
        $outputDir = 'converted/';
        if (!is_dir($outputDir)) {
            mkdir($outputDir, 0755, true);
        }
        
        // Generate output filename
        $outputFilename = $originalName . '_converted_' . date('Y-m-d_H-i-s') . '.' . $targetFormat;
        $outputPath = $outputDir . $outputFilename;
        
        // Get image info and create image resource
        $imageInfo = getimagesize($uploadPath);
        if ($imageInfo === false) {
            throw new Exception('Invalid image file');
        }
        
        $mimeType = $imageInfo['mime'];
        
        // Create image resource from uploaded file
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($uploadPath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($uploadPath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($uploadPath);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($uploadPath);
                break;
            case 'image/bmp':
                $sourceImage = imagecreatefrombmp($uploadPath);
                break;
            case 'image/tiff':
                // TIFF support might be limited
                $sourceImage = imagecreatefromstring(file_get_contents($uploadPath));
                break;
            default:
                throw new Exception('Unsupported image format: ' . $mimeType);
        }
        
        if ($sourceImage === false) {
            throw new Exception('Failed to create image resource');
        }
        
        // Handle transparency for PNG
        if ($targetFormat === 'png') {
            imagealphablending($sourceImage, false);
            imagesavealpha($sourceImage, true);
        }
        
        // Convert and save image
        $success = false;
        switch ($targetFormat) {
            case 'jpg':
            case 'jpeg':
                // Remove transparency for JPEG
                $width = imagesx($sourceImage);
                $height = imagesy($sourceImage);
                $jpegImage = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($jpegImage, 255, 255, 255);
                imagefill($jpegImage, 0, 0, $white);
                imagecopy($jpegImage, $sourceImage, 0, 0, 0, 0, $width, $height);
                $success = imagejpeg($jpegImage, $outputPath, $quality);
                imagedestroy($jpegImage);
                break;
                
            case 'png':
                // PNG quality is different (0-9, where 9 is max compression)
                $pngQuality = 9 - floor($quality / 11);
                $success = imagepng($sourceImage, $outputPath, $pngQuality);
                break;
                
            case 'gif':
                $success = imagegif($sourceImage, $outputPath);
                break;
                
            case 'webp':
                $success = imagewebp($sourceImage, $outputPath, $quality);
                break;
                
            case 'bmp':
                $success = imagebmp($sourceImage, $outputPath, true);
                break;
                
            default:
                throw new Exception('Unsupported output format: ' . $targetFormat);
        }
        
        // Clean up
        imagedestroy($sourceImage);
        
        if (!$success) {
            throw new Exception('Failed to save converted image');
        }
        
        // Get file size
        $fileSize = filesize($outputPath);
        $fileSizeMB = round($fileSize / 1024 / 1024, 2);
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Image converted successfully',
            'converted_image' => $outputPath,
            'filename' => $outputFilename,
            'size' => $fileSizeMB . ' MB',
            'format' => strtoupper($targetFormat),
            'quality' => $quality
        ]);
        
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
    exit;
}
?>