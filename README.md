# ML Auto Scaling với Predictive Scaling

Dự án xây dựng hệ thống Auto Scaling thông minh sử dụng Machine Learning để dự đoán traffic patterns và scale proactively.

## Cấu trúc Project

```
ml-autoscaling/
├── data/                 # Dữ liệu và data generation
├── models/              # ML models (LSTM, ARIMA)
├── api/                 # Prediction API
├── aws/                 # AWS integration
├── tests/               # A/B testing
└── docs/                # Documentation
```

## Yêu cầu hệ thống

- Python 3.8+
- AWS Account với appropriate permissions
- 4GB RAM (cho training models)

## Cài đặt

1. **Clone và setup environment:**
```bash
cd ml-autoscaling
pip install -r requirements.txt
```

2. **Configure AWS credentials:**
```bash
aws configure
```

3. **Generate training data:**
```bash
cd data
python data_generator.py
```

## Hướng dẫn sử dụng (3 tuần)

### Tuần 1: Setup và Data

1. **Tạo dữ liệu training:**
```bash
cd data
python data_generator.py
```

2. **Setup AWS infrastructure:**
```bash
cd aws
# Chỉnh sửa security group IDs trong setup_infrastructure.py
python setup_infrastructure.py
```

### Tuần 2: Training Models

1. **Train ARIMA model:**
```bash
cd models
python arima_model.py
```

2. **Train LSTM model:**
```bash
cd models
python lstm_model.py
```

3. **Start Prediction API:**
```bash
cd api
python prediction_api.py
```

### Tuần 3: Integration và Testing

1. **Test API endpoints:**
```bash
# Test health check
curl http://localhost:5000/health

# Test ARIMA prediction
curl -X POST http://localhost:5000/predict/arima -H "Content-Type: application/json" -d '{"steps": 24}'
```

2. **Run A/B testing:**
```bash
cd tests
python ab_testing.py
```

3. **Start predictive scaling:**
```bash
cd aws
# Chỉnh sửa ASG name trong autoscaling_integration.py
python autoscaling_integration.py
```

## API Endpoints

- `GET /health` - Health check
- `POST /predict/arima` - ARIMA predictions
- `POST /predict/lstm` - LSTM predictions  
- `POST /predict/combined` - Ensemble predictions

## Metrics và Monitoring

### Accuracy Metrics
- **MAE (Mean Absolute Error)**: Độ chính xác trung bình
- **RMSE (Root Mean Square Error)**: Độ lệch chuẩn
- **MAPE (Mean Absolute Percentage Error)**: Phần trăm sai số

### Cost Optimization
- **Cost Savings**: So sánh chi phí predictive vs reactive
- **Resource Utilization**: Hiệu quả sử dụng instances
- **Over/Under Provisioning**: Tỷ lệ cung cấp thừa/thiếu

## Troubleshooting

### Common Issues

1. **Model training fails:**
   - Kiểm tra data format
   - Đảm bảo đủ RAM (4GB+)

2. **API connection errors:**
   - Kiểm tra port 5000 available
   - Verify model files exist

3. **AWS permissions:**
   - Cần quyền EC2, AutoScaling, CloudWatch
   - Kiểm tra security groups

### Debug Commands

```bash
# Check API status
curl http://localhost:5000/health

# Test model loading
python -c "from models.arima_model import ARIMAPredictor; print('OK')"

# Verify AWS credentials
aws sts get-caller-identity
```

## Kết quả mong đợi

- **Cost Savings**: 15-25% so với reactive scaling
- **Performance**: Giảm 30-40% under-provisioning
- **Accuracy**: MAPE < 15% cho predictions 6h

## Tài liệu tham khảo

- [AWS Auto Scaling Documentation](https://docs.aws.amazon.com/autoscaling/)
- [TensorFlow Time Series Guide](https://www.tensorflow.org/tutorials/structured_data/time_series)
- [ARIMA Model Documentation](https://www.statsmodels.org/stable/generated/statsmodels.tsa.arima.model.ARIMA.html)

## Liên hệ

Nếu có vấn đề, tạo issue trong repository hoặc liên hệ qua email.
