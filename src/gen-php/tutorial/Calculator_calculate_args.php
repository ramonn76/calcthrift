<?php
namespace tutorial;

/**
 * Autogenerated by Thrift Compiler (0.18.1)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;

class Calculator_calculate_args
{
    static public $isValidate = false;

    static public $_TSPEC = array(
        1 => array(
            'var' => 'logid',
            'isRequired' => false,
            'type' => TType::I32,
        ),
        2 => array(
            'var' => 'w',
            'isRequired' => false,
            'type' => TType::STRUCT,
            'class' => '\tutorial\Work',
        ),
    );

    /**
     * @var int
     */
    public $logid = null;
    /**
     * @var \tutorial\Work
     */
    public $w = null;

    public function __construct($vals = null)
    {
        if (is_array($vals)) {
            if (isset($vals['logid'])) {
                $this->logid = $vals['logid'];
            }
            if (isset($vals['w'])) {
                $this->w = $vals['w'];
            }
        }
    }

    public function getName()
    {
        return 'Calculator_calculate_args';
    }


    public function read($input)
    {
        $xfer = 0;
        $fname = null;
        $ftype = 0;
        $fid = 0;
        $xfer += $input->readStructBegin($fname);
        while (true) {
            $xfer += $input->readFieldBegin($fname, $ftype, $fid);
            if ($ftype == TType::STOP) {
                break;
            }
            switch ($fid) {
                case 1:
                    if ($ftype == TType::I32) {
                        $xfer += $input->readI32($this->logid);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                case 2:
                    if ($ftype == TType::STRUCT) {
                        $this->w = new \tutorial\Work();
                        $xfer += $this->w->read($input);
                    } else {
                        $xfer += $input->skip($ftype);
                    }
                    break;
                default:
                    $xfer += $input->skip($ftype);
                    break;
            }
            $xfer += $input->readFieldEnd();
        }
        $xfer += $input->readStructEnd();
        return $xfer;
    }

    public function write($output)
    {
        $xfer = 0;
        $xfer += $output->writeStructBegin('Calculator_calculate_args');
        if ($this->logid !== null) {
            $xfer += $output->writeFieldBegin('logid', TType::I32, 1);
            $xfer += $output->writeI32($this->logid);
            $xfer += $output->writeFieldEnd();
        }
        if ($this->w !== null) {
            if (!is_object($this->w)) {
                throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
            }
            $xfer += $output->writeFieldBegin('w', TType::STRUCT, 2);
            $xfer += $this->w->write($output);
            $xfer += $output->writeFieldEnd();
        }
        $xfer += $output->writeFieldStop();
        $xfer += $output->writeStructEnd();
        return $xfer;
    }
}
