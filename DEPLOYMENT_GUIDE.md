# 🚀 AWS DEPLOYMENT GUIDE

## Prerequisites
- AWS Account với credit card
- AWS CLI installed
- Python 3.8+ installed

## Step 1: AWS CLI Setup
```bash
# Install AWS CLI (nếu chưa có)
pip install awscli

# Configure credentials
aws configure
# AWS Access Key ID: [Your Key]
# AWS Secret Access Key: [Your Secret]
# Default region name: us-east-1
# Default output format: json

# Test connection
aws sts get-caller-identity
```

## Step 2: Create IAM Role
```bash
cd aws
python create_iam_role.py
```
**Expected output**: ✅ IAM setup completed!

## Step 3: Create Security Group
```bash
python create_security_group.py
```
**Expected output**: Security Group ID: sg-xxxxxxxxx
**⚠️ SAVE THIS ID - you'll need it next!**

## Step 4: Setup Infrastructure
```bash
python setup_infrastructure.py
# Enter Security Group ID when prompted
```
**Expected output**: 
- ✅ Infrastructure setup completed!
- Launch Template ID
- Auto Scaling Group created

## Step 5: Verify Deployment
```bash
# Check instances are running
aws ec2 describe-instances --filters "Name=tag:Project,Values=ML-Predictive-Scaling"

# Check Auto Scaling Group
aws autoscaling describe-auto-scaling-groups --auto-scaling-group-names ml-predictive-asg
```

## Step 6: Test Local ML Pipeline
```bash
# Go back to project root
cd ..

# Install dependencies
pip install -r requirements.txt

# Run full demo
python run_demo.py
```

## Step 7: Deploy Prediction API to EC2
```bash
# Get EC2 instance IP
aws ec2 describe-instances --filters "Name=tag:Project,Values=ML-Predictive-Scaling" --query "Reservations[*].Instances[*].PublicIpAddress"

# SSH to instance (replace IP)
ssh -i your-key.pem ec2-user@YOUR-INSTANCE-IP

# On EC2 instance:
sudo yum install -y git python3-pip
git clone https://github.com/your-repo/ml-autoscaling.git
cd ml-autoscaling
pip3 install -r requirements.txt
python3 api/prediction_api.py
```

## Step 8: Start Predictive Scaling
```bash
# Back on local machine
cd aws
python autoscaling_integration.py
```

## Step 9: Monitor Results
```bash
# Watch CloudWatch metrics
aws cloudwatch get-metric-statistics \
  --namespace AWS/EC2 \
  --metric-name CPUUtilization \
  --dimensions Name=AutoScalingGroupName,Value=ml-predictive-asg \
  --start-time 2024-01-01T00:00:00Z \
  --end-time 2024-01-01T23:59:59Z \
  --period 300 \
  --statistics Average

# Check scaling activities
aws autoscaling describe-scaling-activities --auto-scaling-group-name ml-predictive-asg
```

## Troubleshooting

### Issue 1: Permission Denied
```bash
# Check IAM permissions
aws iam get-user
aws iam list-attached-user-policies --user-name YOUR-USERNAME
```

### Issue 2: Security Group Not Found
```bash
# List security groups
aws ec2 describe-security-groups --group-names ml-autoscaling-sg
```

### Issue 3: Instance Launch Failed
```bash
# Check launch template
aws ec2 describe-launch-templates --launch-template-names ml-autoscaling-template

# Check instance logs
aws logs describe-log-groups
```

### Issue 4: API Not Responding
```bash
# SSH to instance and check
ssh -i your-key.pem ec2-user@INSTANCE-IP
sudo netstat -tlnp | grep 5000
ps aux | grep python
```

## Cost Monitoring
```bash
# Check current costs
aws ce get-cost-and-usage \
  --time-period Start=2024-01-01,End=2024-01-31 \
  --granularity MONTHLY \
  --metrics BlendedCost \
  --group-by Type=DIMENSION,Key=SERVICE
```

## Cleanup (Important!)
```bash
# Delete Auto Scaling Group
aws autoscaling delete-auto-scaling-group --auto-scaling-group-name ml-predictive-asg --force-delete

# Delete Launch Template
aws ec2 delete-launch-template --launch-template-name ml-autoscaling-template

# Delete Security Group
aws ec2 delete-security-group --group-name ml-autoscaling-sg

# Delete IAM resources
aws iam detach-role-policy --role-name EC2-CloudWatch-Role --policy-arn arn:aws:iam::ACCOUNT:policy/EC2-CloudWatch-Policy
aws iam delete-policy --policy-arn arn:aws:iam::ACCOUNT:policy/EC2-CloudWatch-Policy
aws iam remove-role-from-instance-profile --instance-profile-name EC2-CloudWatch-Role --role-name EC2-CloudWatch-Role
aws iam delete-instance-profile --instance-profile-name EC2-CloudWatch-Role
aws iam delete-role --role-name EC2-CloudWatch-Role
```

## Expected Costs (t2.micro)
- **Development**: $5-10/day
- **Testing**: $20-30/week  
- **Demo**: $50-100/month

⚠️ **Always cleanup resources after demo to avoid charges!**
